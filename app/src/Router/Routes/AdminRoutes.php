<?php

namespace Router\Routes;

use Controllers\AssetController;
use Controllers\CategoryController;
use Core\Errors\MiddlewareException;
use Core\ServiceContainer;
use Router\Middlewares\IsUserAdminMiddleware;
use Services\Session\SessionService;

class AdminRoutes extends Routes implements RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }
                ServiceContainer::get(CategoryController::class)->show();
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->get(
            $prefix . '/categories/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }
                ServiceContainer::get(CategoryController::class)->show();
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->get(
            $prefix . '/categories/create/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }
                ServiceContainer::get(CategoryController::class)->showCreate();
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->post(
            $prefix . '/categories/create/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }

                $name = htmlspecialchars($_POST['name'] ?? '');
                $description = htmlspecialchars($_POST['description'] ?? '');

                ServiceContainer::get(CategoryController::class)->create($name, $description);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->get(
            $prefix . '/categories/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }
				ServiceContainer::get(CategoryController::class)->showEdit($slug['id']);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->put(
            $prefix . '/categories/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }
                $name = htmlspecialchars($_POST['name'] ?? '');
                $description = htmlspecialchars($_POST['description'] ?? '');

				ServiceContainer::get(CategoryController::class)->edit($slug['id'], $name, $description);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->delete(
            $prefix . '/categories/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }
                ServiceContainer::get(CategoryController::class)->delete($slug['id']);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->get(
            $prefix . '/assets/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }
                ServiceContainer::get(AssetController::class)->show();
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->get(
            $prefix . '/assets/create/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }
                ServiceContainer::get(AssetController::class)->showCreate();
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->post(
            $prefix . '/assets/create/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }
                $name = htmlspecialchars($_POST['name'] ?? '');
                $info = htmlspecialchars($_POST['info'] ?? '');
                $description = htmlspecialchars($_POST['description'] ?? '');
                $images = $_POST['images'] ? explode(';', $_POST['images']) : [];
                $price = intval($_POST['price'] ?? 0);
                $engine_version = intval($_POST['engine_version'] ?? 0);
                $category_id = intval($_POST['category_id'] ?? 0);

                ServiceContainer::get(AssetController::class)->create(
                    $name, $info, $description, $images, $price, $engine_version, $category_id
                );
            }
        );
        $this->router->get(
            $prefix . '/assets/{id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }
                ServiceContainer::get(AssetController::class)->showEdit($slug['id']);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->put(
            $prefix . '/assets/{id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                }
                $name = htmlspecialchars($_POST['name'] ?? '');
                $info = htmlspecialchars($_POST['info'] ?? '');
                $description = htmlspecialchars($_POST['description'] ?? '');
                $images = $_POST['images'] ? explode(';', $_POST['images']) : [];
                $price = intval($_POST['price'] ?? 0);
                $engine_version = intval($_POST['engine_version'] ?? 0);
                $category_id = intval($_POST['category_id'] ?? 0);

                    ServiceContainer::get(AssetController::class)->edit(
                        $slug['id'], $name, $info, $description, $images, $price, $engine_version, $category_id
                    );
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->delete(
            $prefix . '/assets/{id}/', function (array $slug, ?MiddlewareException   $middleware) {
                if ($middleware) {
                    header('Location: /', true);
					die();
                } 
                ServiceContainer::get(AssetController::class)->delete($slug['id']);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
    }
}
