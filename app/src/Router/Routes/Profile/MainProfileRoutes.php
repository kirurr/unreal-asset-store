<?php

namespace Router\Routes\Profile;

use Controllers\Profile\MainController;
use Core\Errors\MiddlewareException;
use Core\ServiceContainer;
use Router\Middlewares\IsUserMiddleware;
use Router\Routes\RoutesInterface;

use Router\Routes\Routes;
use Services\Session\SessionService;

class MainProfileRoutes extends Routes implements RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException $middlware) {
                if ($middlware) {
                    redirect('/');
                }

                ServiceContainer::get(MainController::class)->show();
            }, [(new IsUserMiddleware(ServiceContainer::get(SessionService::class)))]
        );

    }
}

