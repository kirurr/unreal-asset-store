<?php

namespace Router\Routes\Profile;

use Controllers\AssetController;
use Controllers\FileController;
use Controllers\ImageController;
use Core\Errors\MiddlewareException;
use Core\ServiceContainer;
use Router\Middlewares\IsUserAssetAuthorMiddleware;
use Router\Middlewares\IsUserMiddleware;
use Router\Routes\Routes;
use Router\Routes\RoutesInterface;
use Router\Router;
use Services\Validation\AssetValidationService;
use UseCases\Asset\GetAssetUseCase;
use DomainException;
use Exception;

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
            $prefix . '/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                // $data = $this->assetController->getAdminAssetsPageData();
                // renderView('profile/assets/index', $data);
                redirect('/profile/');
            }, [new IsUserMiddleware()]
        );

        $this->router->get(
            $prefix . '/create/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                $data = $this->assetController->getCreatePageData();
                renderView('profile/assets/create', $data);
            }, [new IsUserMiddleware()]
        );
        $this->router->post(
            $prefix . '/create/', function (array $slug, ?MiddlewareException $middleware) {
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
                        $data['name'],
                        $data['info'],
                        $data['description'],
                        $images,
                        $data['price'],
                        $data['engine_version'],
                        $data['category_id']
                    );
                    redirect('/profile/');
                } catch (DomainException $e) {
                    $pageData = $this->assetController->getCreatePageData();

                    http_response_code(400);
                    renderView(
                        'profile/assets/create', [
                            'errorMessage' => $e->getMessage(),
                            'errors' => $errors,
                            'categories' => $pageData['categories'],
                            'previousData' => [
                                'name' => $data['name'],
                                'info' => $data['info'],
                                'description' => $data['description'],
                                'price' => $data['price'],
                                'engine_version' => $data['engine_version'],
                                'category_id' => $data['category_id'],
                            ]
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserMiddleware()]
        );
        $this->router->get(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException $middleware) {
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
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->put(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException $middleware) {
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
                        $data['name'],
                        $data['info'],
                        $data['description'],
                        $data['price'],
                        $data['engine_version'],
                        $data['category_id'],
                    );

                    redirect('/profile/');
                } catch (DomainException $e) {
                    $pageData = $this->assetController->getEditPageData($slug['id']);

                    http_response_code(400);
                    renderView(
                        'profile/assets/edit', [
                            'categories' => $pageData['categories'],
                            'asset' => $pageData['asset'],
                            'errorMessage' => $e->getMessage(),
                            'errors' => $errors,
                            'previousData' => [
                                'name' => $data['name'],
                                'info' => $data['info'],
                                'description' => $data['description'],
                                'price' => $data['price'],
                                'engine_version' => $data['engine_version'],
                                'category_id' => $data['category_id'],
                            ],
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->delete(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $this->assetController->delete($slug['id']);
                    redirect('/profile/');
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
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        // IMAGES
        $this->router->get(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                $data = $this->imageController->getImagesPageData($slug['id']);
                renderView('profile/assets/images/index', $data);
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->post(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                if (strlen($_FILES['images']['name']['0']) === 0) {
                    $images = [];
                } else {
                    $images = $_FILES['images'];
                }
                $previous_image_order = intval($_POST['_last_order'] ?? 0);

                $errors = $this->assetValidationService->validateImages($images);

                try {
                    if ($errors) {
                        throw new DomainException($errors['images']);
                    }

                    $this->imageController->create($slug['id'], $images, $previous_image_order);
                    redirect('/profile/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
                    $pageData = $this->imageController->getImagesPageData($slug['id']);

                    http_response_code(400);
                    renderView(
                        'profile/assets/images/index', [
                            'errorMessage' => $e->getMessage(),
                            ...$pageData,
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->patch(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                [$errors, $data] = $this->assetValidationService->validatePreviewImage($_POST['id'] ?? '');

                try {
                    if ($errors) {
                        throw new DomainException($errors['image_id']);
                    }

                    $this->imageController->updatePreviewImage($slug['id'], $data['image_id']);
                    redirect('/profile/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
                    $pageData = $this->imageController->getImagesPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'profile/assets/images/index', [
                            'errorMessage' => $e->getMessage(),
                            ...$pageData,
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->put(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException $middleware) {
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
                        $data['image_id'],
                        $data['image_name'],
                        $data['tmp_name'],
                        $data['image_order'],
                        $data['old_image_path']
                    );

                    redirect('/profile/assets/' . $slug['id'] . '/images/');
                } catch (DomainException $e) {
                    $pageData = $this->imageController->getImagesPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'profile/assets/images/index', [
                            'errorMessage' => $e->getMessage(),
                            ...$pageData,
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->delete(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException $middleware) {
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
                            ...$data,
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        // FILES
        $this->router->get(
            $prefix . '/{id}/files/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                try {
                    $data = $this->fileController->getMainPageData($slug['id']);
                    renderView('profile/assets/files/index', [
                        ...$data,
                    ]);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->get(
            $prefix . '/{id}/files/create/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                try {
                    $data = $this->fileController->getMainPageData($slug['id']);
                    renderView('profile/assets/files/create', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->post(
            $prefix . '/{id}/files/create/', function (array $slug, ?MiddlewareException $middleware) {
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
                        $data['name'],
                        $data['version'],
                        $data['description'],
                        $data['file_name'],
                        $data['path'],
                    );

                    redirect('/profile/assets/' . $slug['id'] . '/files');
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'profile/assets/files/create', [
                            'errorMessage' => $e->getMessage(),
                            'previousData' => $data,
                            'errors' => $errors,
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->get(
            $prefix . '/{id}/files/{file_id}/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $data = $this->fileController->getEditPageData($slug['id'], $slug['file_id']);
                    renderView('profile/assets/files/edit', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->put(
            $prefix . '/{id}/files/{file_id}/', function (array $slug, ?MiddlewareException $middleware) {
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
                        $data['name'],
                        $data['version'],
                        $data['description'],
                        $data['file_name'],
                        $data['path'],
                        $data['old_path']
                    );

                    redirect('/profile/assets/' . $slug['id'] . '/files');
                } catch (DomainException $e) {
                    $pageData = $this->fileController->getEditPageData($slug['id'], $slug['file_id']);

                    http_response_code(400);
                    renderView(
                        'profile/assets/files/edit', [
                            'errors' => $errors,
                            ...$pageData,
                            'previousData' => $data,
                            'errorMessage' => $e->getMessage()
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );

        $this->router->delete(
            $prefix . '/{id}/files/{file_id}/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $this->fileController->delete($slug['id'], $slug['file_id']);
                    redirect('/profile/assets/' . $slug['id'] . '/files/');
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAssetAuthorMiddleware(ServiceContainer::get(GetAssetUseCase::class))]
        );
    }
}
