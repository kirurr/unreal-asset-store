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
use Router\Routes\RoutesInterface;
use Services\Validation\UserValidationService;

class UserRoutes extends Routes implements RoutesInterface
{
    private UserController $userController;
    private UserValidationService $userValidationService;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->userController = ServiceContainer::get(UserController::class);
        $this->userValidationService = ServiceContainer::get(UserValidationService::class);
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
            }, [new IsUserAdminMiddleware()]
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
            }, [new IsUserAdminMiddleware()]
        );

        $this->router->put(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                [$errors, $data] = $this->userValidationService->validateUpdate(
                    $_POST['name'] ?? '', 
                    $_POST['password'] ?? '', 
                    $_POST['email'] ?? '', 
                    $_POST['role'] ?? ''
                );
                try {
                    if ($errors) {
                        throw new DomainException('One or more fields are invalid');
                    }

                    $this->userController->update($slug['id'], $data[ 'name' ], $data[ 'email' ], $data[ 'role' ], $data[ 'password' ]);
                    redirect('/admin/users');
                } catch (DomainException $e) {
                    $pageData = $this->userController->getEditPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'admin/users/edit', [
                        'user' => $pageData['user'],
                        'assets' => $pageData['assets'],
                        'previousData' => [
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'role' => $data['role'],
                        'password' => $data['password']
                        ],
                        'errorMessage' => $e->getMessage(),
                        'errors' => $errors
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware()]
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
                        ...$data,
                        'errorMessage' => $e->getMessage()
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware()]
        );
    }
}

