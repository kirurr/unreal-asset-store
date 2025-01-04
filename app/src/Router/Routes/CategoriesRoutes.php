<?php

namespace Router\Routes;

use Controllers\CategoriesPageController;
use Core\ServiceContainer;
use Exception;
use Router\Router;
use Router\Routes\RoutesInterface;

use Router\Routes\Routes;


class CategoriesRoutes extends Routes implements RoutesInterface {
	private CategoriesPageController $categoriesPageController;

	public function __construct(Router $router) {
		parent::__construct($router);
		$this->categoriesPageController = ServiceContainer::get(CategoriesPageController::class);
	}

    public function defineRoutes(string $prefix = ''): void
    {
		$this->router->get($prefix . '/', function () {
			try {
				$data = $this->categoriesPageController->getCategoriesPageData();
				renderView('categories', $data);
			} catch (Exception $e) {
				$this->handleException($e);
			}
		});
    }
}
