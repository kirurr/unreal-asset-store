<?php

namespace Router\Routes;

use Controllers\AssetsPageController;
use Core\Errors\MiddlewareException;
use Core\ServiceContainer;
use DomainException;
use Entities\AssetFilters;
use Router\Middlewares\IsUserPurchasedAssetMiddleware;
use Router\Router;
use Services\Session\SessionService;
use UseCases\Asset\GetAssetUseCase;
use UseCases\File\GetFileByIdUseCase;
use UseCases\Purchase\IsUserPurchasedAssetUseCase;
use Exception;

class AssetsRoutes extends Routes implements RoutesInterface
{
    private AssetsPageController $assetsPageController;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->assetsPageController = ServiceContainer::get(AssetsPageController::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug) {
                $filters = new AssetFilters(
                    category_id: isset($_GET['category_id']) ? intval($_GET['category_id']) : null,
                    user_id: isset($_GET['user_id']) ? intval($_GET['user_id']) : null,
                    search: isset($_GET['search']) ? htmlspecialchars($_GET['search']) : null,
                    engine_version: isset($_GET['engine_version']) ? htmlspecialchars($_GET['engine_version']) : null,
                    interval: isset($_GET['interval']) ? intval($_GET['interval']) : null,
                    byNew: isset($_GET['byNew']) ? htmlspecialchars($_GET['byNew']) : null,
                    byPopular: isset($_GET['byPopular']) ? htmlspecialchars($_GET['byPopular']) : null,
                    asc: isset($_GET['asc']) ? htmlspecialchars($_GET['asc']) : null,
                    minPrice: isset($_GET['minPrice']) ? intval($_GET['minPrice']) : null,
                    maxPrice: isset($_GET['maxPrice']) ? intval($_GET['maxPrice']) : null,
                    limit: isset($_GET['limit']) ? intval($_GET['limit']) : null
                );

                try {
                    $data = $this->assetsPageController->getAssetsPageData($filters);
                    $data['filters'] = $filters;

                    $minPrice = null;
                    $maxPrice = null;

                    foreach ($data['assets'] as $asset) {
                        if ($minPrice === null || $asset->price < $minPrice) {
                            $minPrice = $asset->price;
                        }
                        if ($maxPrice === null || $asset->price > $maxPrice) {
                            $maxPrice = $asset->price;
                        }
                    }
                    $data['prices'] = ['min' => $minPrice, 'max' => $maxPrice];

                    renderView('assets/assets', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }
        );
        $this->router->get(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException $middleware) {
                $isUserPurchasedAsset = false;
                if (!$middleware) {
                    $isUserPurchasedAsset = true;
                }
                try {
                    $data = $this->assetsPageController->getAssetPageData($slug['id']);
                    $data['isUserPurchasedAsset'] = $isUserPurchasedAsset;
                    renderView('assets/asset', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserPurchasedAssetMiddleware(
                ServiceContainer::get(SessionService::class),
                ServiceContainer::get(GetFileByIdUseCase::class),
                ServiceContainer::get(IsUserPurchasedAssetUseCase::class),
                ServiceContainer::get(GetAssetUseCase::class),
            )]
        );

        $this->router->get(
            $prefix . '/{id}/purchase/', function (array $slug, ?MiddlewareException $middleware) {
                if (!$middleware) {
                    redirect('/assets/' . $slug['id'] . '/');
                }

                try {
                    $data = $this->assetsPageController->getPurchasePageData(
                        $slug['id'],
                    );
                    renderView('assets/purchase', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserPurchasedAssetMiddleware(
                ServiceContainer::get(SessionService::class),
                ServiceContainer::get(GetFileByIdUseCase::class),
                ServiceContainer::get(IsUserPurchasedAssetUseCase::class),
                ServiceContainer::get(GetAssetUseCase::class),
            )]
        );

        $this->router->post(
            $prefix . '/{id}/purchase/', function (array $slug, ?MiddlewareException $middleware) {
                if (!$middleware) {
                    redirect('/assets/' . $slug['id'] . '/');
                }

                try {
					$this->assetsPageController->purchaseAsset($slug['id']);
					redirect('/assets/' . $slug['id'] . '/');
				} catch (DomainException $e) {
                    $data = $this->assetsPageController->getPurchasePageData(
                        $slug['id'],
                    );
					$data['errorMessage'] = $e->getMessage();
                    renderView('assets/purchase', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserPurchasedAssetMiddleware(
                ServiceContainer::get(SessionService::class),
                ServiceContainer::get(GetFileByIdUseCase::class),
                ServiceContainer::get(IsUserPurchasedAssetUseCase::class),
                ServiceContainer::get(GetAssetUseCase::class),
            )]
        );

        $this->router->get(
            $prefix . '/{id}/files/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/assets/' . $slug['id'] . '/');
                }

                try {
                    $data = $this->assetsPageController->getFilesPageData(
                        $slug['id'],
                    );
                    renderView('assets/files', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserPurchasedAssetMiddleware(
                ServiceContainer::get(SessionService::class),
                ServiceContainer::get(GetFileByIdUseCase::class),
                ServiceContainer::get(IsUserPurchasedAssetUseCase::class),
                ServiceContainer::get(GetAssetUseCase::class),
            )]
        );

        $this->router->get(
            $prefix . '/{id}/files/{file_id}/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/assets/' . $slug['id'] . '/');
                }

                try {
                    $file = $this->assetsPageController->getFileForDownload($slug['id'], $slug['file_id']);

                    $download_data = $file->getDownloadData();

                    $this->assetsPageController->changeAssetPurchaseCount($slug['id'], true);

                    header('Content-Type: ' . $download_data['mime_type']);
                    header('Content-Length: ' . $download_data['filesize']);
                    header('Content-Disposition: inline; filename="' . $download_data['file_name'] . '"');
					header('Content-Transfer-Encoding: binary');
					header('Accept-Ranges: bytes');
					header("Connection: close");
                    @readfile($download_data['path']);

                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserPurchasedAssetMiddleware(
                ServiceContainer::get(SessionService::class),
                ServiceContainer::get(GetFileByIdUseCase::class),
                ServiceContainer::get(IsUserPurchasedAssetUseCase::class),
                ServiceContainer::get(GetAssetUseCase::class),
            )]
        );
    }
}
