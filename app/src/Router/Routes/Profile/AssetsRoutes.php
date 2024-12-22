<?php

namespace Router\Routes\Profile;

use Controllers\Profile\AssetController;
use Controllers\Profile\FileController;
use Controllers\Profile\ImageController;

use Core\Errors\MiddlewareException;
use Router\Middlewares\IsUserAdminMiddleware;
use Router\Middlewares\IsUserAssetAuthorMiddleware;
use Router\Middlewares\IsUserMiddleware;
use Core\ServiceContainer;
use Router\Routes\Routes;
use Services\Session\SessionService;
use Router\Routes\RoutesInterface;
use UseCases\Asset\GetAssetUseCase;

class AssetsRoutes extends Routes implements RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/create/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                ServiceContainer::get(AssetController::class)->showCreate();
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

                ServiceContainer::get(AssetController::class)->create(
                    $name, $info, $description, $images, $price, $engine_version, $category_id
                );
            }, [new IsUserMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->get(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                ServiceContainer::get(AssetController::class)->showEdit($slug['id']);
            }, [ new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class)) ]
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

                    ServiceContainer::get(AssetController::class)->edit(
                        $slug['id'], $name, $info, $description, $price, $engine_version, $category_id
                    );
            }, [ new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class)) ]
        );


        $this->router->delete(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                } 
                ServiceContainer::get(AssetController::class)->delete($slug['id']);
            }, [ new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class)) ]
        );

        // IMAGES
        $this->router->get(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                ServiceContainer::get(ImageController::class)->show($slug['id']);
            }, [ new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class)) ]
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

                ServiceContainer::get(ImageController::class)->create($slug['id'], $images, $previous_image_order);
            }, [ new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class)) ]
        );
        

        $this->router->patch(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                } 
                $image_id = intval($_POST['id'] ?? 0);

                ServiceContainer::get(ImageController::class)->updatePreviewImage($slug['id'], $image_id);
            }, [ new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class)) ]
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

                ServiceContainer::get(ImageController::class)->update(
                    $slug['id'], $image_id, $image_name, $tmp_name, $image_order, $old_image_path
                );
            }, [ new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class)) ]
        );

        $this->router->delete(
            $prefix . '/{id}/images/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                } 
                $image_id = intval($_POST['id'] ?? 0);

                ServiceContainer::get(ImageController::class)->delete($slug['id'], $image_id);
            }, [ new IsUserAssetAuthorMiddleware(ServiceContainer::get(SessionService::class), ServiceContainer::get(GetAssetUseCase::class)) ]
        );

        // FILES
        $this->router->get(
            $prefix . '/{id}/files/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                ServiceContainer::get(FileController::class)->show($slug['id']);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->get(
            $prefix . '/{id}/files/create/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                ServiceContainer::get(FileController::class)->showCreate($slug['id']);
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

                ServiceContainer::get(FileController::class)->create($slug['id'], $name, $version, $description, $file_name, $path);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->get(
            $prefix . '/{id}/files/{file_id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                ServiceContainer::get(FileController::class)->showEdit($slug['id'], $slug['file_id']);
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

                ServiceContainer::get(FileController::class)->update($slug['id'], $slug['file_id'], $name, $version, $description, $file_name, $path, $old_path);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->delete(
            $prefix . '/{id}/files/{file_id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                ServiceContainer::get(FileController::class)->delete($slug['id'], $slug['file_id']);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
    }
}

