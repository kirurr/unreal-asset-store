<?php

namespace Router\Routes;

use Controllers\AssetsPageController;
use Core\ServiceContainer;
use Entities\AssetFilters;
use Exception;
use Router\Router;


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

                    renderView('assets', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            } 
        );
    }

}
