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
use Services\Validation\AssetValidationService;

class AssetsRoutes extends Routes implements RoutesInterface
{
    private AssetController $assetController;
    private ImageController $imageController;
    private FileController $fileController;
    private AssetValidationService $assetValidationService;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->assetController = ServiceContainer::get(AssetController::class);
        $this->imageController = ServiceContainer::get(ImageController::class);
        $this->fileController = ServiceContainer::get(FileController::class);
        $this->assetValidationService = ServiceContainer::get(AssetValidationService::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                $data = $this->assetController->getAdminAssetsPageData();
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

                [$errors, $data] = $this->assetValidationService->validate(
                    name: $_POST['name'] ?? '',
                    info: $_POST['info'] ?? '',
                    description: $_POST['description'] ?? '',
                    price: $_POST['price'] ?? '',
                    engine_version: $_POST['engine_version'] ?? '',
                    category_id: $_POST['category_id'] ?? '',
                    images: $images
                );

                try {
                    if ($errors) {
                        throw new DomainException('One or more fields are invalid');
                    }

                    $this->assetController->create(
                        $data[ 'name' ],
                        $data[ 'info' ],
                        $data[ 'description' ],
						$images,
                        $data[ 'price' ],
                        $data[ 'engine_version' ],
                        $data[ 'category_id' ]
                    );
                    redirect('/admin/assets/');
                } catch (DomainException $e) {
                    $pageData = $this->assetController->getCreatePageData();
                        
                    http_response_code(400);
                    renderView(
                        'admin/assets/create', [
                        'errorMessage' => $e->getMessage(),
                        'errors' => $errors,
                        'categories' => $pageData['categories'],
                        'previousData' => [
                        'name' => $data[ 'name' ],
                        'info' => $data[ 'info' ],
                        'description' => $data[ 'description' ],
                        'price' => $data[ 'price' ],
                        'engine_version' => $data[ 'engine_version' ],
                        'category_id' => $data[ 'category_id' ],
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

                [$errors, $data] = $this->assetValidationService->validateUpdate(
                    name: $_POST['name'] ?? '',
                    info: $_POST['info'] ?? '',
                    description: $_POST['description'] ?? '',
                    price: $_POST['price'] ?? '',
                    engine_version: $_POST['engine_version'] ?? '',
                    category_id: $_POST['category_id'] ?? '',
                );
                try {
					if ($errors) {
						throw new DomainException('One or more fields are invalid');
					}
                    $this->assetController->edit(
                        $slug['id'],
                        $data[ 'name' ],
                        $data[ 'info' ],
                        $data[ 'description' ],
                        $data[ 'price' ],
                        $data[ 'engine_version' ],
                        $data[ 'category_id' ],
                    );

                    redirect('/admin/assets/');
                } catch (DomainException $e) {
                    $pageData = $this->assetController->getEditPageData($slug['id']);

                    http_response_code(400);
                    renderView(
                        'admin/assets/edit', [
                        'categories' => $pageData['categories'],
                        'asset' => $pageData['asset'],
                        'errorMessage' => $e->getMessage(),
                        'errors' => $errors,
                        'previousData' => [
                        'name' => $data[ 'name' ],
                        'info' => $data[ 'info' ],
                        'description' => $data[ 'description' ],
                        'price' => $data[ 'price' ],
                        'engine_version' => $data[ 'engine_version' ],
                        'category_id' => $data[ 'category_id' ],
                        ],
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

                $errors = $this->assetValidationService->validateImages($images);

                try {
                    if ($errors) {
                        throw new DomainException($errors['images']);
                    }

                    $this->imageController->create($slug['id'], $images, $previous_image_order);
                    redirect('/admin/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
                    $pageData = $this->imageController->getImagesPageData($slug['id']);

                    http_response_code(400);
                    renderView(
                        'admin/assets/images/index', [
                        'errorMessage' => $e->getMessage(),
                        'asset_id' => $slug['id'],
                        'asset' => $pageData['asset'],
                        'images' => $pageData['images'],
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

                [$errors, $data] = $this->assetValidationService->validatePreviewImage($_POST['id'] ?? '');

                try {
                    if ($errors) {
                        throw new DomainException(['image_id']);
                    }

                    $this->imageController->updatePreviewImage($slug['id'], $data[ 'image_id' ]);
                    redirect('/admin/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
                    $pageData = $this->imageController->getImagesPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'admin/assets/images/index', [
                        'errorMessage' => $e->getMessage(),
                        'asset_id' => $slug['id'],
                        'asset' => $pageData['asset'],
                        'images' => $pageData['images'],
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

                [$errors, $data] = $this->assetValidationService->validateUpdateImage(
                    $_POST['id'] ?? 0,
                    $_POST['image_order'] ?? 0,
                    $_FILES['images']['name'] ?? '',
                    $_FILES['images']['tmp_name'] ?? '',
                    $_POST['path'] ?? ''
                );
                try {
                    if ($errors) {
                        throw new DomainException($errors['image']);
                    }

                    $this->imageController->update(
                        $slug['id'],
                        $data[ 'image_id' ],
                        $data[ 'image_name' ],
                        $data[ 'tmp_name' ],
                        $data[ 'image_order' ],
                        $data[ 'old_image_path' ]
                    );

                    redirect('/admin/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
                    $pageData = $this->imageController->getImagesPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'admin/assets/images/index', [
                        'errorMessage' => $e->getMessage(),
                        'asset_id' => $slug['id'],
                        'asset' => $pageData['asset'],
                        'images' => $pageData['images'],
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

                [$errors, $data] = $this->assetValidationService->validateFile(
                    name: $_POST['name'] ?? '',
                    version: $_POST['version'] ?? '',
                    description: $_POST['description'] ?? '',
                    file_name: $_FILES['file']['name'] ?? '',
                    path: $_FILES['file']['tmp_name'] ?? ''
                );

                try {
                    if ($errors) {
                        throw new DomainException('One or more fields are invalid');
                    }

                    $this->fileController->create(
                        $slug['id'],
                        $data[ 'name' ],
                        $data[ 'version' ],
                        $data[ 'description' ],
                        $data[ 'file_name' ],
                        $data[ 'path' ],
                    );

                    redirect("/admin/assets/" . $slug['id'] . "$/iles");
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'admin/assets/files/create', [
                        'errorMessage' => $e->getMessage(),
                        'previousData' => [
                        'name' => $data[ 'name' ],
                        'version' => $data[ 'version' ],
                        'description' => $data[ 'description' ],
                        'file_name' => $data[ 'file_name' ],
                        ],
                        'asset_id' => $slug['id'],
                        'errors' => $errors,
                        ]
                    );
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

                [$errors, $data] = $this->assetValidationService->validateUpdateFile(
                    $_POST['name'] ?? '',
                    $_POST['version'] ?? '',
                    $_POST['description'] ?? '',
                    $_FILES['file']['name'] ?? '',
                    $_FILES['file']['tmp_name'] ?? '',
                    $_POST['path'] ?? ''
                );

                try {
                    if ($errors) {
                        throw new DomainException('One or more fields are invalid');
                    }

                    $this->fileController->update(
                        $slug['id'],
                        $slug['file_id'],
                        $data[ 'name' ],
                        $data[ 'version' ],
                        $data[ 'description' ],
                        $data[ 'file_name' ],
                        $data[ 'path' ],
                        $data[ 'old_path' ]
                    );

                    redirect("/admin/assets/" . $slug['id'] . "/files");
                } catch (DomainException $e) {
                    $pageData = $this->fileController->getEditPageData($slug['id'], $slug['file_id']);
                    http_response_code(400);
                    renderView(
                        'admin/assets/files/edit', [
                        'errors' => $errors,
                        'file' => $pageData['file'],
                        'asset_id' => $slug['id'],
                        'previousData' => [
                        'name' => $data[ 'name' ],
                        'version' => $data[ 'version' ],
                        'description' => $data[ 'description' ],
                        'file_name' => $data[ 'file_name' ],
                        ],
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
