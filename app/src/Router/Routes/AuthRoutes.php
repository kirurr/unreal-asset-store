<?php

namespace Router\Routes;

use Controllers\AuthController;
use Core\Errors\Error;
use Core\ServiceContainer;
use Router\Middlewares\IsUserMiddleware;
use Services\Session\SessionService;

class AuthRoutes extends Routes implements RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get($prefix . '/signin', function (array $slug, ?Error $middlewareError) {
            if ($middlewareError) {
                ServiceContainer::get(AuthController::class)->showSignInPage();
            } else {
                header('Location: /');
            }
        }, [new IsUserMiddleware(ServiceContainer::get(SessionService::class))]);

        $this->router->get($prefix . '/signup', function (array $slug, ?Error $middlewareError) {
            if ($middlewareError) {
                ServiceContainer::get(AuthController::class)->showSignUpPage();
            } else {
                header('Location: /');
            }
        }, [new IsUserMiddleware(ServiceContainer::get(SessionService::class))]);

        $this->router->post($prefix . '/signin', function () {
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = htmlspecialchars($_POST['password'] ?? '');
            ServiceContainer::get(AuthController::class)->signIn($email, $password);
        });

        $this->router->post($prefix . '/signup', function () {
            $name = htmlspecialchars($_POST['name'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = htmlspecialchars($_POST['password'] ?? '');

            ServiceContainer::get(AuthController::class)->signUp($name, $email, $password);
        });

        $this->router->get($prefix . '/signout', function () {
            ServiceContainer::get(AuthController::class)->signOut();
        });
    }
}
