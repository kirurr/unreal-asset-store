<?php

namespace Router\Routes;

use Controllers\MainPageController;
use Core\ServiceContainer;

class MainRoutes extends Routes implements RoutesInterface
{
    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get($prefix . '/', function () {
            ServiceContainer::get(MainPageController::class)->show();
        });

        /* $this->router->get('/{id}', function (ServiceContainer $container, array $slug, ?Error $middlewareError) { */
        /* if ($middlewareError) { */
        /* http_response_code(401); */
        /* echo json_encode($middlewareError->getData()); */
        /* die(); */
        /* } */
        /* var_dump($slug); */
        /* }, [new IsUserMiddleware($this->container->get(SessionService::class))]); */
    }
}
