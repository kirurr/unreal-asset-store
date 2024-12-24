<?php

namespace Router\Routes\Profile;

use Controllers\ProfileController;
use Core\Errors\MiddlewareException;
use Core\ServiceContainer;
use Exception;
use Router\Middlewares\IsUserMiddleware;
use Router\Router;
use Router\Routes\RoutesInterface;

use Router\Routes\Routes;
use Services\Session\SessionService;

class MainProfileRoutes extends Routes implements RoutesInterface
{
    private ProfileController $profileController;
    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->profileController = ServiceContainer::get(ProfileController::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException $middlware) {
                if ($middlware) {
                    redirect('/');
                }

                $data = $this->profileController->getProfileData();
                try 
                {
                    renderView('profile/index', $data);
                } 
                catch (Exception $e) 
                {
                    $this->handleException($e);
                }
            }, [(new IsUserMiddleware(ServiceContainer::get(SessionService::class)))]
        );

    }
}

