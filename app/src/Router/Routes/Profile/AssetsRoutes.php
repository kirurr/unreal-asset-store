<?php

namespace Router\Routes\Profile;

use Controllers\AssetController;
use Controllers\FileController;
use Controllers\ImageController;
use Core\Errors\MiddlewareException;
use DomainException;
use Exception;
use Router\Middlewares\IsUserAssetAuthorMiddleware;
use Core\ServiceContainer;
use Router\Middlewares\IsUserMiddleware;
use Router\Routes\Routes;
use Services\Session\SessionService;
use Router\Routes\RoutesInterface;
use UseCases\Asset\GetAssetUseCase;

class AssetsRoutes extends Routes implements RoutesInterface
{
    private AssetController $assetController;
    private ImageController $imageController;
    private FileController $fileController;

    public function __construct($router)
    {
        parent::__construct($router);
        $this->assetController = ServiceContainer::get(AssetController::class);
        $this->imageController = ServiceContainer::get(ImageController::class);
        $this->fileController = ServiceContainer::get(FileController::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                $data = $this->assetController->getAdminAssetsPageData();
                renderView('profile/assets/index', $data);
            }, [new IsUserMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->get(
            $prefix . '/create/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                $data = $this->assetController->getCreatePageData();
                renderView('profile/assets/create', $data);
            }, [new IsUserMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->post(
            $prefix . '/create/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                if (strlen($_FILES['images']['name']['0']) === 0) {
                    $images = [];
                } else {
                    $images = $_FILES['images'];
                }
                $name = htmlspecialchars($_POST['name'] ?? '');
                $info = htmlspecialchars($_POST['info'] ?? '');
                $description = htmlspecialchars($_POST['description'] ?? '');
                $price = intval($_POST['price'] ?? 0);
                $engine_version = htmlspecialchars($_POST['engine_version'] ?? '');
                $category_id = intval($_POST['category_id'] ?? 0);

                try {
                    $this->assetController->create(
                        $name, $info, $description, $images, $price, $engine_version, $category_id
                    );
                    redirect('/profile/assets/');
                } catch (DomainException $e) {
                    $data = $this->assetController->getCreatePageData();
                        
                    http_response_code(400);
                    renderView(
                        'profile/assets/create', [
                        'errorMessage' => $e->getMessage(),
                        'categories' => $data['categories'],
                        'previousData' => [
                        'name' => $name,
                        'info' => $info,
                        'description' => $description,
                        'price' => $price,
                        'engine_version' => $engine_version,
                        'category_id' => $category_id,
                        ]
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->get(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                try {
                    $data = $this->assetController->getEditPageData($slug['id']);
                    renderView('profile/assets/edit', $data);
                } catch (DomainException $e) {
                    http_response_code(404);
					redirect('/profile/assets');
                } catch (Exception $e) {
                    $this->handleException($e);
                }

            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->put(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                $name = htmlspecialchars($_POST['name'] ?? '');
                $info = htmlspecialchars($_POST['info'] ?? '');
                $description = htmlspecialchars($_POST['description'] ?? '');
                $price = intval($_POST['price'] ?? 0);
                $engine_version = htmlspecialchars($_POST['engine_version'] ?? '');
                $category_id = intval($_POST['category_id'] ?? 0);

                try {
                    $this->assetController->edit($slug['id'], $name, $info, $description, $price, $engine_version, $category_id);
                    redirect('/profile/assets/');
                } catch (DomainException $e) {
                    $data = $this->assetController->getEditPageData($slug['id']);

                    http_response_code(400);
                    renderView(
                        'profile/assets/edit', [
                        'categories' => $data['categories'],
                        'asset' => $data['asset'],
                        'errorMessage' => $e->getMessage(),
                        'previousData' => [
                        'name' => $name,
                        'info' => $info,
                        'description' => $description,
                        'price' => $price,
                        'engine_version' => $engine_version,
                        'category_id' => $category_id,
                        ],
                        'fields' => ['name', 'info', 'description', 'images', 'price', 'engine_version', 'category_id']
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );


        $this->router->delete(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                } 
                try {
                    $this->assetController->delete($slug['id']);
                    redirect('/profile/assets');
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'profile/assets/edit', [
                        'errorMessage' => $e->getMessage(),
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );
        
        // IMAGES
        $this->router->get(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                $data = $this->imageController->getImagesPageData($slug['id']);
                renderView('profile/assets/images/index', $data);
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->post(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                } 
                if (strlen($_FILES['images']['name']['0']) === 0) {
                    $images = [];
                } else {
                    $images = $_FILES['images'];
                }
                $previous_image_order = intval($_POST['last_order'] ?? 0);

                try {
                    $this->imageController->create($slug['id'], $images, $previous_image_order);
					redirect('/profile/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
					$data = $this->imageController->getImagesPageData($slug['id']);

                    http_response_code(400);
                    renderView(
                        'profile/assets/images/index', [
                        'errorMessage' => $e->getMessage(),
                        'asset_id' => $slug['id'],
                        'asset' => $data['asset'],
						'images' => $data['images'],
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );
        

        $this->router->patch(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                } 
                $image_id = intval($_POST['id'] ?? 0);

                try {
                    $this->imageController->updatePreviewImage($slug['id'], $image_id);
					redirect('/profile/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
					$data = $this->imageController->getImagesPageData($slug['id']);

                    http_response_code(400);
                    renderView(
                        'profile/assets/images/index', [
                        'errorMessage' => $e->getMessage(),
                        'asset_id' => $slug['id'],
                        'asset' => $data['asset'],
						'images' => $data['images'],
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->put(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                } 
                $image_id = intval($_POST['id'] ?? 0);
                $image_order = intval($_POST['image_order'] ?? 0);
                $image_name = $_FILES['images']['name'] ?? '';
                $tmp_name = $_FILES['images']['tmp_name']?? '';
                $old_image_path = htmlspecialchars($_POST['path'] ?? '');

                try {
                    $this->imageController->update($slug['id'], $image_id, $image_name, $tmp_name, $image_order, $old_image_path);
					redirect('/profile/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
					$data = $this->imageController->getImagesPageData($slug['id']);

                    http_response_code(400);
                    renderView(
                        'profile/assets/images/index', [
                        'errorMessage' => $e->getMessage(),
                        'asset_id' => $slug['id'],
                        'asset' => $data['asset'],
						'images' => $data['images'],
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->delete(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                } 
                $image_id = intval($_POST['id'] ?? 0);

                try {
                    $this->imageController->delete($slug['id'], $image_id);
					redirect('/profile/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
					$data = $this->imageController->getImagesPageData($slug['id']);

                    http_response_code(400);
                    renderView(
                        'profile/assets/images/index', [
                        'errorMessage' => $e->getMessage(),
                        'asset_id' => $slug['id'],
                        'asset' => $data['asset'],
						'images' => $data['images'],
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );

        // FILES
        $this->router->get(
            $prefix . '/{id}/files/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                try {
                    $data = $this->fileController->getMainPageData($slug['id']);
                    renderView('profile/assets/files/index', ['files' => $data['files'], 'asset_id' => $slug['id']]);
                } catch (Exception $e) {
                    $this->handleException($e);
                } 
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->get(
            $prefix . '/{id}/files/create/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                renderView('profile/assets/files/create', ['asset_id' => $slug['id']]);
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->post(
            $prefix . '/{id}/files/create/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                $name = htmlspecialchars($_POST['name'] ?? '');
                $version = htmlspecialchars($_POST['version'] ?? '');
                $description = htmlspecialchars($_POST['description'] ?? '');
                $file_name = htmlspecialchars($_FILES['file']['name'] ?? '');
                $path = htmlspecialchars($_FILES['file']['tmp_name'] ?? '');

                try {
                    $this->fileController->create($slug['id'], $name, $version, $description, $file_name, $path);
					redirect('/profile/assets/' . $slug['id'] . '/files/');
                } catch (Exception $e) {
                    $this->handleException($e);
                } 
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->get(
            $prefix . '/{id}/files/{file_id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $data = $this->fileController->getEditPageData($slug['id'], $slug['file_id']);
                    renderView('profile/assets/files/edit', ['file' => $data['file'], 'asset_id' => $slug['id']]);
                } catch (Exception $e) {
                    $this->handleException($e);
                } 
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->put(
            $prefix . '/{id}/files/{file_id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                $name = htmlspecialchars($_POST['name'] ?? '');
                $version = htmlspecialchars($_POST['version'] ?? '');
                $description = htmlspecialchars($_POST['description'] ?? '');
                $file_name = htmlspecialchars($_FILES['file']['name'] ?? '');
                $path = htmlspecialchars($_FILES['file']['tmp_name'] ?? '');
                $old_path = htmlspecialchars($_POST['path'] ?? '');

                try {
                    $this->fileController->update($slug['id'], $slug['file_id'], $name, $version, $description, $file_name, $path, $old_path);
					redirect('/profile/assets/' . $slug['id'] . '/files/');
                } catch (DomainException $e) {
                    $data = $this->fileController->getEditPageData($slug['id'], $slug['file_id']);
                    http_response_code(400);
                    renderView(
                        'profile/assets/files/edit', [
                        'file' => $data['file'],
                        'asset_id' => $slug['id'],
                        'errorMessage' => $e->getMessage()
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->delete(
            $prefix . '/{id}/files/{file_id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $this->fileController->delete($slug['id'], $slug['file_id']);
					redirect('/profile/assets/' . $slug['id'] . '/files/');
                } catch (Exception $e) {
                    http_response_code(500);
                    renderView('error', ['error' => $e->getMessage()]);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class))]
        );
    }
}
