<?php

namespace Router\Routes\Admin;

use Core\Errors\MiddlewareException;
use Router\Middlewares\IsUserAdminMiddleware;
use Core\ServiceContainer;
use Router\Routes\Routes;
use Services\Session\SessionService;
use Router\Routes\RoutesInterface;

class MainAdminRoutes extends Routes implements RoutesInterface {
	public function defineRoutes(string $prefix	= ''): void {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    header('Location: /', true);
                    die();
                }
				header('Location: /admin/categories', true);
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
	}
}
