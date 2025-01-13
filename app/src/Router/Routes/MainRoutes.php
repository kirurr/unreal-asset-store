<?php

namespace Router\Routes;

use Controllers\MainPageController;
use Core\ServiceContainer;
use Router\Router;
use UseCases\Asset\Variant;
use Exception;

class MainRoutes extends Routes implements RoutesInterface
{
    private MainPageController $mainPageController;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->mainPageController = ServiceContainer::get(MainPageController::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function () {
                $query = isset($_GET['variant']) ? htmlspecialchars($_GET['variant']) : 'new-week';

                $variant = (Variant::tryFrom($query) ?? Variant::NEW_WEEK);

                try {
                    $data = $this->mainPageController->getMainPageData($variant);
                    renderView('main', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }
        );
    }
}
