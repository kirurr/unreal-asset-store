<?php 

namespace Router\Routes\Admin;

use Controllers\CategoryController;
use Core\Errors\MiddlewareException;
use DomainException;
use Exception;
use Router\Middlewares\IsUserAdminMiddleware;
use Core\ServiceContainer;
use Router\Router;
use Router\Routes\Routes;
use Services\Session\SessionService;
use Router\Routes\RoutesInterface;

class CategoriesRoutes extends Routes implements RoutesInterface
{
    private CategoryController $categoryController;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->categoryController = ServiceContainer::get(CategoryController::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $data = $this->categoryController->getCategoryPageData();    
                    renderView('admin/categories/index', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->get(
            $prefix . '/create/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                renderView('admin/categories/create');
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->post(
            $prefix . '/create/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                $name = htmlspecialchars($_POST['name'] ?? '');
                $description = htmlspecialchars($_POST['description'] ?? '');

                try {
                    $this->categoryController->create($name, $description);
                    redirect('/admin/categories/');
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'admin/categories/create', [
                        'errorMessage' => $e->getMessage(),
                        'previousData' => [
                        'name' => $name,
                        'description' => $description,
                        ]
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );
        $this->router->get(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
					redirect('/');
                }
                try {
                    $data = $this->categoryController->getEditPageData($slug['id']);
                    renderView('admin/categories/edit', $data);
                } catch (DomainException $e) {
                    http_response_code(404);
					redirect('/admin/categories');
                } catch (Exception $e) {
					$this->handleException($e);
                }
            }, [new IsUserAdminMiddleware(ServiceContainer::get(SessionService::class))]
        );

        $this->router->put(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                $name = htmlspecialchars($_POST['name'] ?? '');
                $description = htmlspecialchars($_POST['description'] ?? '');

                try {
                    $this->categoryController->edit($slug['id'], $name, $description);
                    redirect('/admin/categories/');
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'admin/categories/edit', [
                        'errorMessage' => $e->getMessage(),
                        'previousData' => [
                        'name' => $name,
                        'description' => $description,
                        ],
                        'fields' => ['name', 'description', 'image']
                        ]
                    );
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
                    $this->categoryController->delete($slug['id']);
                    redirect('/admin/categories');
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'admin/categories/edit', [
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
