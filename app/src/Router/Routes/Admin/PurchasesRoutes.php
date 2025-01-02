<?php

namespace Router\Routes\Admin;

use Controllers\PurchasesController;
use Core\Errors\MiddlewareException;
use Core\ServiceContainer;
use DomainException;
use Exception;
use Router\Middlewares\IsUserAdminMiddleware;
use Router\Routes\Routes;
use Router\Routes\RoutesInterface;
use Router\Router;
use Services\Session\SessionService;

class PurchasesRoutes extends Routes implements RoutesInterface
{
    private PurchasesController $purchasesController;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->purchasesController = ServiceContainer::get(PurchasesController::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $data = $this->purchasesController->getPurchasesPageData();
					renderView('admin/purchases/index', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

		$this->router->delete(
			$prefix . '/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
				if ($middleware) {
					redirect('/');
				}

				try {
					$this->purchasesController->deletePurchase($slug['id']);
					redirect('/admin/purchases');
				} catch (DomainException $e) {
					http_response_code(400);
					renderView(
						'admin/purchases/index', [
						'errorMessage' => $e->getMessage(),
						]
					);
				} catch (Exception $e) {
					$this->handleException($e);
				}
			}, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
		);
    }
}
