<?php

namespace Router\Routes;

use Controllers\CategoryController;
use Core\ServiceContainer;

class AdminRoutes extends Routes implements RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get($prefix . '/', function () {
            ServiceContainer::get(CategoryController::class)->show();
        });
        $this->router->get($prefix . '/categories/', function () {
            ServiceContainer::get(CategoryController::class)->show();
        });
        $this->router->get($prefix . '/categories/create/', function () {
            ServiceContainer::get(CategoryController::class)->showCreate();
        });
        $this->router->post($prefix . '/categories/create/', function () {
            $name = htmlspecialchars($_POST['name'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');
            $image = htmlspecialchars($_POST['image'] ?? '');

            ServiceContainer::get(CategoryController::class)->create($name, $description, $image);
        });
    }
}
