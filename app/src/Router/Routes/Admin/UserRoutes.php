<?php

namespace Router\Routes\Admin;

use Controllers\Admin\UserController;
use Core\Errors\MiddlewareException;
use Router\Middlewares\IsUserAdminMiddleware;
use Core\ServiceContainer;
use Router\Routes\Routes;
use Services\Session\SessionService;
use Router\Routes\RoutesInterface;

class UserRoutes extends Routes implements RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    header('Location: /', true);
                    die();
                }
                ServiceContainer::get(UserController::class)->show();
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->get(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    header('Location: /', true);
                    die();
                }
                ServiceContainer::get(UserController::class)->showEdit($slug['id']);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->put(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    header('Location: /', true);
                    die();
                }
                $name = $_POST['name'] ?? null;
                $email = $_POST['email'] ?? null;
                $role = $_POST['role'] ?? null;
                $password = $_POST['password'] ?? null;

                ServiceContainer::get(UserController::class)->update($slug['id'], $name, $email, $role, $password);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->delete(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    header('Location: /', true);
                    die();
                }

                ServiceContainer::get(UserController::class)->delete($slug['id']);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
    }
}

