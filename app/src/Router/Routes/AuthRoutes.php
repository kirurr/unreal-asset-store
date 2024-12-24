<?php

namespace Router\Routes;

use Controllers\AuthController;
use Core\Errors\MiddlewareException;
use Core\ServiceContainer;
use DomainException;
use Exception;
use Router\Middlewares\IsUserMiddleware;
use Router\Router;
use Services\Session\SessionService;

class AuthRoutes extends Routes implements RoutesInterface
{
    private AuthController $authController;

    public function __construct(Router $router)
	{
		parent::__construct($router);
		$this->authController = ServiceContainer::get(AuthController::class);
	}

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/signin/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    renderView('auth/signin', []);
                } 

                redirect('/');
            }, [new IsUserMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->get(
            $prefix . '/signup/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    renderView('auth/signup', []);
                }

                redirect('/');
            }, [new IsUserMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->post(
            $prefix . '/signin/', function (array $slug, ?MiddlewareException $middleware) {
                if (!$middleware) {
                    redirect('/');
                }

                $email = htmlspecialchars($_POST['email'] ?? '');
                $password = htmlspecialchars($_POST['password'] ?? '');
                try {
                    $this->authController->signIn($email, $password);
                    redirect('/');
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'auth/signin', [
                        'errorMessage' => $e->getMessage(),
                        'previousData' => [
                        'email' => $email,
                        'password' => $password
                        ],
                        'fields' => ['email', 'password']
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->post(
            $prefix . '/signup/', function (array $slug, ?MiddlewareException $middleware) {
                if (!$middleware) {
                    redirect('/');
                }

                $name = htmlspecialchars($_POST['name'] ?? '');
                $email = htmlspecialchars($_POST['email'] ?? '');
                $password = htmlspecialchars($_POST['password'] ?? '');

                try {
                    $this->authController->signUp($name, $email, $password);
                    redirect('/');
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'auth/signup', [
                        'errorMessage' => $e->getMessage(),
                        'previousData' => [
                        'email' => $email,
                        'password' => $password,
                        'name' => $name
                        ],
                        'fields' => ['email']
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }
        );

        $this->router->get(
            $prefix . '/signout/', function () {
                $this->authController->signOut();
                redirect('/');
            }
        );
    }
}
