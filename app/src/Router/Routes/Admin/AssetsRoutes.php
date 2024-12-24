<?php

namespace Router\Routes\Admin;

use Controllers\AssetController;
use Controllers\FileController;
use Controllers\ImageController;
use Core\Errors\MiddlewareException;
use DomainException;
use Exception;
use Router\Middlewares\IsUserAdminMiddleware;
use Core\ServiceContainer;
use Router\Router;
use Router\Routes\Routes;
use Services\Session\SessionService;
use Router\Routes\RoutesInterface;

class AssetsRoutes extends Routes implements RoutesInterface
{
    private AssetController $assetController;
    private ImageController $imageController;
    private FileController $fileController;

    public function __construct(Router $router)
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

                $data = $this->assetController->getAssetsPageData();
                renderView('admin/assets/index', $data);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->get(
            $prefix . '/create/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                $data = $this->assetController->getCreatePageData();
                renderView('admin/assets/create', $data);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
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
                    redirect('/admin/assets/');
                } catch (DomainException $e) {
                    $data = $this->assetController->getCreatePageData();
                        
                    http_response_code(400);
                    renderView(
                        'admin/assets/create', [
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
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->get(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                try {
                    $data = $this->assetController->getEditPageData($slug['id']);
                    renderView('admin/assets/edit', $data);
                } catch (DomainException $e) {
                    http_response_code(404);
					redirect('/admin/assets');
                } catch (Exception $e) {
                    $this->handleException($e);
                }

            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
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
                    redirect('/admin/assets/');
                } catch (DomainException $e) {
                    $data = $this->assetController->getEditPageData($slug['id']);

                    http_response_code(400);
                    renderView(
                        'admin/assets/edit', [
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
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );


        $this->router->delete(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                } 
                try {
                    $this->assetController->delete($slug['id']);
					redirect('/admin/assets');
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'admin/assets/edit', [
                        'errorMessage' => $e->getMessage(),
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        
        // IMAGES
        $this->router->get(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                $data = $this->imageController->getImagesPageData($slug['id']);
                renderView('admin/assets/images/index', $data);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
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
					redirect('/admin/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
					$data = $this->imageController->getImagesPageData($slug['id']);

                    http_response_code(400);
                    renderView(
                        'admin/assets/images/index', [
                        'errorMessage' => $e->getMessage(),
                        'asset_id' => $slug['id'],
                        'asset' => $data['asset'],
						'images' => $data['images'],
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        

        $this->router->patch(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                } 
                $image_id = intval($_POST['id'] ?? 0);

                try {
                    $this->imageController->updatePreviewImage($slug['id'], $image_id);
					redirect('/admin/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
					$data = $this->imageController->getImagesPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'admin/assets/images/index', [
                        'errorMessage' => $e->getMessage(),
                        'asset_id' => $slug['id'],
                        'asset' => $data['asset'],
						'images' => $data['images'],
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
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
					redirect('/admin/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
					$data = $this->imageController->getImagesPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'admin/assets/images/index', [
                        'errorMessage' => $e->getMessage(),
                        'asset_id' => $slug['id'],
                        'asset' => $data['asset'],
						'images' => $data['images'],
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->delete(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                } 
                $image_id = intval($_POST['id'] ?? 0);

                try {
                    $this->imageController->delete($slug['id'], $image_id);
                    redirect('/admin/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
					$data = $this->imageController->getImagesPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'admin/assets/images/index', [
                        'errorMessage' => $e->getMessage(),
                        'asset_id' => $slug['id'],
                        'asset' => $data['asset'],
						'images' => $data['images'],
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        // FILES
        $this->router->get(
            $prefix . '/{id}/files/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                try {
                    $data = $this->fileController->getMainPageData($slug['id']);
                    renderView('admin/assets/files/index', ['files' => $data['files'], 'asset_id' => $slug['id']]);
                } catch (Exception $e) {
                    $this->handleException($e);
                } 
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->get(
            $prefix . '/{id}/files/create/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                renderView('admin/assets/files/create', ['asset_id' => $slug['id']]);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
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
                    redirect("/admin/assets/" . $slug['id'] . "$/files");
                } catch (Exception $e) {
                    $this->handleException($e);
                } 
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->get(
            $prefix . '/{id}/files/{file_id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $data = $this->fileController->getEditPageData($slug['id'], $slug['file_id']);
                    renderView('admin/assets/files/edit', ['file' => $data['file'], 'asset_id' => $slug['id']]);
                } catch (Exception $e) {
                    $this->handleException($e);
                } 
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
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
                    redirect("/admin/assets/" . $slug['id'] . "/files");
                } catch (DomainException $e) {
                    $data = $this->fileController->getEditPageData($slug['id'], $slug['file_id']);
                    http_response_code(400);
                    renderView(
                        'admin/assets/files/edit', [
                        'file' => $data['file'],
                        'asset_id' => $slug['id'],
                        'errorMessage' => $e->getMessage()
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->delete(
            $prefix . '/{id}/files/{file_id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $this->fileController->delete($slug['id'], $slug['file_id']);
                    redirect("/admin/assets/" . $slug['id'] . "/files");
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
    }
}
