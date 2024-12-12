<?php

namespace Router\Routes;

use Controllers\MainPageController;
use Core\ServiceContainer;

class MainRoutes extends Routes implements RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function () {
                ServiceContainer::get(MainPageController::class)->show();
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
