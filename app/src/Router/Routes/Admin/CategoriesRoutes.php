<?php 

namespace Router\Routes\Admin;

use Controllers\Admin\CategoryController;
use Core\Errors\MiddlewareException;
use Router\Middlewares\IsUserAdminMiddleware;
use Core\ServiceContainer;
use Router\Routes\Routes;
use Services\Session\SessionService;
use Router\Routes\RoutesInterface;

class CategoriesRoutes extends Routes implements RoutesInterface
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
            $prefix . '/create/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    header('Location: /', true);
                    die();
                }
                ServiceContainer::get(CategoryController::class)->showCreate();
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->post(
            $prefix . '/create/', function (array $slug, ?MiddlewareException $middleware) {
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
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    header('Location: /', true);
                    die();
                }
                ServiceContainer::get(CategoryController::class)->showEdit($slug['id']);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->put(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
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
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    header('Location: /', true);
                    die();
                }
                ServiceContainer::get(CategoryController::class)->delete($slug['id']);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

    }
}
