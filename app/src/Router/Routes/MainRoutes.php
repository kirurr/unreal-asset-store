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

        $this->router->get('/{id}', function (ServiceContainer $container, array $slug, ?Error $middlewareError) {
            if ($middlewareError) {
                http_response_code(401);
                echo json_encode($middlewareError->getData());
                die();
            }
            var_dump($slug);
        }, [new IsUserMiddleware($this->container->get(SessionService::class))]);

        $this->router->post('/api/signin', function (ServiceContainer $container) {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $container->get(AuthController::class)->signIn($email, $password);
        });

        $this->router->post('/api/signup', function (ServiceContainer $container) {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $container->get(AuthController::class)->signUp($name, $email, $password);
        });

        $this->router->get('/api/signout', function (ServiceContainer $container) {
            $container->get(AuthController::class)->signOut();
        });
    }
}
