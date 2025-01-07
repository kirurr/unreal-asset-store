<?php

namespace Router\Routes;

use Controllers\AuthController;
use Core\Errors\MiddlewareException;
use Core\ServiceContainer;
use DomainException;
use Exception;
use Router\Middlewares\IsUserMiddleware;
use Router\Router;
use Services\Validation\UserValidationService;

class AuthRoutes extends Routes implements RoutesInterface
{
    private AuthController $authController;
    private UserValidationService $userValidationService;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->authController = ServiceContainer::get(AuthController::class);
        $this->userValidationService = ServiceContainer::get(UserValidationService::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/signin/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    renderView('auth/signin', []);
                } 

                redirect('/');
            }, [new IsUserMiddleware()]
        );

        $this->router->get(
            $prefix . '/signup/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    renderView('auth/signup', []);
                }

                redirect('/');
            }, [new IsUserMiddleware()]
        );

        $this->router->post(
            $prefix . '/signin/', function (array $slug, ?MiddlewareException $middleware) {
                if (!$middleware) {
                    redirect('/');
                }

                [$errors, $data] = $this->userValidationService->validateSignIn(
                    $_POST['email'] ?? '',
                    $_POST['password'] ?? ''
                );

                try {
                    if ($errors) {
                        throw new DomainException('One or more fields are invalid');
                    }

                    $this->authController->signIn($data['email'], $data['password']);
                    redirect('/');
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'auth/signin', [
                        'errorMessage' => $e->getMessage(),
                        'previousData' => [
                        'email' => $data['email'],
                        'password' => $data['password']
                        ],
                        'errors' => $errors,
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserMiddleware()]
        );

        $this->router->post(
            $prefix . '/signup/', function (array $slug, ?MiddlewareException $middleware) {
                if (!$middleware) {
                    redirect('/');
                }


                [$errors, $data] = $this->userValidationService->validateSignUp(
                    $_POST['name'] ?? '',
                    $_POST['email'] ?? '',
                    $_POST['password'] ?? ''
                );

                try {
                    if ($errors) {
                        throw new DomainException('One or more fields are invalid');
                    }

                    $this->authController->signUp($data['name'], $data['email'], $data['password']);
                    redirect('/');
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'auth/signup', [
                        'errorMessage' => $e->getMessage(),
                        'previousData' => [
                        'email' => $data['email'],
                        'password' => $data['password'],
                        'name' => $data['name']
                        ],
                        'errors' => $errors,
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserMiddleware()]
        );

        $this->router->get(
            $prefix . '/signout/', function () {
                $this->authController->signOut();
                redirect('/');
            }, [new IsUserMiddleware()]
        );
    }
}
