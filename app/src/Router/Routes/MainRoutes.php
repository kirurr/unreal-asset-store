<?php

namespace Router\Routes;

use Controllers\MainPageController;
use Core\ServiceContainer;
use Exception;
use Router\Router;
use UseCases\Asset\Variant;

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
                $query = isset($_GET['variant']) ? htmlspecialchars($_GET['variant']) : 'today';
                $variant = (Variant::tryFrom($query) ?? Variant::NEW_TODAY);

                try {
                    $data = $this->mainPageController->getMainPageData($variant);
                    renderView('main', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }
        );


        // TODO: test download logic
        // encapsulate to a service/controller
        // check for user auth
        $this->router->get(
            '/download/', function () {
                renderView('test');
            }
        );

        $this->router->get(
            '/download/1/', function () {
                $file = __DIR__ . '/../storage/test.css';

                header('Content-Type: text/css');
                header('Content-Length: ' . filesize($file));
                header('Content-Disposition: inline; filename="test.css"');
                readfile($file);
            }
        );
    }
}
