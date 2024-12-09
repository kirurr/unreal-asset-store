<?php

namespace Router\Routes;

use Controllers\CategoryController;
use Core\ServiceContainer;
use Router\Middlewares\IsUserAdminMiddleware;
use Services\Session\SessionService;

class AdminRoutes extends Routes implements RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get($prefix . '/', function () {
            ServiceContainer::get(CategoryController::class)->show();
        });
        $this->router->get($prefix . '/categories/', function () {
            ServiceContainer::get(CategoryController::class)->show();
        });
        $this->router->get($prefix . '/categories/create/', function () {
            ServiceContainer::get(CategoryController::class)->showCreate();
        });
        $this->router->post($prefix . '/categories/create/', function () {
            $name = htmlspecialchars($_POST['name'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            ServiceContainer::get(CategoryController::class)->create($name, $description);
        });
        $this->router->get($prefix . '/categories/{id}/', function (array $slug, ?string $middlewareError) {
            if (!$middlewareError) {
                ServiceContainer::get(CategoryController::class)->showEdit($slug['id']);
            } else {
                header('Location: /admin/categories', true);
            }
        }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]);

        $this->router->put($prefix . '/categories/{id}/', function (array $slug, ?string $middlewareError) {
            $name = htmlspecialchars($_POST['name'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');
            if (!$middlewareError) {
                ServiceContainer::get(CategoryController::class)->edit($slug['id'], $name, $description);
            } else {
                header('Location: /admin/categories', true);
            }
        }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]);

        $this->router->delete($prefix . '/categories/{id}/', function (array $slug, ?string $middlewareError) {
            if (!$middlewareError) {
                ServiceContainer::get(CategoryController::class)->delete($slug['id']);
            } else {
                header('Location: /admin/categories', true);
            }
        }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]);
    }
}
