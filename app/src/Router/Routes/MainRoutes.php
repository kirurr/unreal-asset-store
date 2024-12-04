<?php

namespace Router\Routes;

use Controllers\AuthController;
use Controllers\MainPageController;
use Core\Errors\Error;
use Core\ServiceContainer;
use Router\Middlewares\IsUserMiddleware;
use Router\Router;
use Services\Session\SessionService;

class MainRoutes implements RoutesInterface
{
    private ServiceContainer $container;

    public function __construct(
        private Router $router
    ) {
        $this->container = $router->container;
    }

    public function defineRoutes(): void
    {
        $this->router->get('/', function (ServiceContainer $container) {
            $container->get(MainPageController::class)->show();
        });

        $this->router->get('/signin', function (ServiceContainer $container, array $slug, ?Error $middlewareError) {
            if ($middlewareError) {
                $container->get(AuthController::class)->showSignInPage();
            } else {
                header('Location: /');
            }
        }, [new IsUserMiddleware($this->container->get(SessionService::class))]);

        $this->router->get('/signup', function (ServiceContainer $container, array $slug, ?Error $middlewareError) {
            if ($middlewareError) {
                $container->get(AuthController::class)->showSignUpPage();
            } else {
                header('Location: /');
            }
        }, [new IsUserMiddleware($this->container->get(SessionService::class))]);


        $this->router->post('/signin', function (ServiceContainer $container) {
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = htmlspecialchars($_POST['password'] ?? '');

            $container->get(AuthController::class)->signIn($email, $password);
        });

        $this->router->post('/signup', function (ServiceContainer $container) {
            $name = htmlspecialchars($_POST['name'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = htmlspecialchars($_POST['password'] ?? '');

            $container->get(AuthController::class)->signUp($name, $email, $password);
        });

        $this->router->get('/signout', function (ServiceContainer $container) {
            $container->get(AuthController::class)->signOut();
        });

        $this->router->get('/{id}', function (ServiceContainer $container, array $slug, ?Error $middlewareError) {
            if ($middlewareError) {
                http_response_code(401);
                echo json_encode($middlewareError->getData());
                die();
            }
            var_dump($slug);
        }, [new IsUserMiddleware($this->container->get(SessionService::class))]);
    }
}
