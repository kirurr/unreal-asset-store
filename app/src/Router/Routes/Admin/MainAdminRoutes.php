<?php

namespace Router\Routes\Admin;

use Core\Errors\MiddlewareException;
use Router\Middlewares\IsUserAdminMiddleware;
use Core\ServiceContainer;
use Router\Router;
use Router\Routes\Routes;
use Services\Session\SessionService;
use Router\Routes\RoutesInterface;

class MainAdminRoutes extends Routes implements RoutesInterface {
	public function __construct(Router $router) {
		parent::__construct($router);
	}
	public function defineRoutes(string $prefix	= ''): void {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
					redirect('/');
                }
				redirect('/admin/categories');
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
	}
}
