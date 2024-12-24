<?php

namespace Router\Routes\Admin;

use Controllers\UserController;
use Core\Errors\MiddlewareException;
use DomainException;
use Exception;
use Router\Middlewares\IsUserAdminMiddleware;
use Core\ServiceContainer;
use Router\Router;
use Router\Routes\Routes;
use Services\Session\SessionService;
use Router\Routes\RoutesInterface;

class UserRoutes extends Routes implements RoutesInterface
{
    private UserController $userController;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->userController = ServiceContainer::get(UserController::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $data = $this->userController->getUsersPageData();
                    renderView('admin/users/index', $data);
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'admin/users/index', [
                        'errorMessage' => $e->getMessage(),
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->get(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $data = $this->userController->getEditPageData($slug['id']);
                    renderView('admin/users/edit', $data);
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'admin/users/edit', [
                        'errorMessage' => $e->getMessage(),
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->put(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                $name = $_POST['name'] ?? null;
                $email = $_POST['email'] ?? null;
                $role = $_POST['role'] ?? null;
                $password = $_POST['password'] ?? null;

                try {
                    $this->userController->update($slug['id'], $name, $email, $role, $password);
                    redirect('/admin/users');

                } catch (DomainException $e) {
                    $data = $this->userController->getEditPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'admin/users/edit', [
                        'user' => $data['user'],
                        'assets' => $data['assets'],
                        'errorMessage' => $e->getMessage()
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->delete(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
					redirect('/');
                }

                try {
                    $this->userController->delete($slug['id']);
                    redirect('/admin/users');
                } catch (DomainException $e) {
                    http_response_code(400);
                    $data = $this->userController->getEditPageData($slug['id']);
                    renderView(
                        'admin/users/edit', [
                        'user' => $data['user'],
                        'assets' => $data['assets'],
                        'errorMessage' => $e->getMessage()
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
    }
}

