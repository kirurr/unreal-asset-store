<?php

namespace Router\Routes;

use Controllers\ProfilePageController;
use Core\Errors\MiddlewareException;
use Core\ServiceContainer;
use Router\Middlewares\IsUserMiddleware;
use Router\Routes\RoutesInterface;

use Router\Routes\Routes;
use Services\Session\SessionService;

class ProfileRoutes extends Routes implements RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException $middlware) {
				if ($middlware) {
					redirect('/');
				}

                ServiceContainer::get(ProfilePageController::class)->show();
            }, [(new IsUserMiddleware(ServiceContainer::get(SessionService::class)))]
        );
    }
}

