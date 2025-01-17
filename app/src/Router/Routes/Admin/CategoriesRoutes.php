<?php

namespace Router\Routes\Admin;

use Controllers\CategoryController;
use Core\Errors\MiddlewareException;
use DomainException;
use Entities\Category;
use Exception;
use Router\Middlewares\IsUserAdminMiddleware;
use Core\ServiceContainer;
use Router\Router;
use Router\Routes\Routes;
use Services\Session\SessionService;
use Router\Routes\RoutesInterface;
use Services\Validation\CategoryValidationService;

class CategoriesRoutes extends Routes implements RoutesInterface
{
    private CategoryController $categoryController;
    private CategoryValidationService $categoryValidationService;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->categoryController = ServiceContainer::get(CategoryController::class);
        $this->categoryValidationService = ServiceContainer::get(CategoryValidationService::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/',
            function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $data = $this->categoryController->getCategoryPageData();
                    renderView('admin/categories/index', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            },
            [new IsUserAdminMiddleware()]
        );

        $this->router->get(
            $prefix . '/create/',
            function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                renderView('admin/categories/create');
            },
            [new IsUserAdminMiddleware()]
        );

        $this->router->post(
            $prefix . '/create/',
            function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                [$errors, $data] = $this->categoryValidationService->validate(
                    $_POST['name'] ?? '',
                    $_POST['description'] ?? ''
                );

                try {
                    if ($errors) {
                        throw new DomainException('One or more fields are invalid');
                    }

                    $this->categoryController->create($data['name'], $data['description']);
                    redirect('/admin/categories/');
                } catch (DomainException $e) {
                    http_response_code(400);
                    renderView(
                        'admin/categories/create',
                        [
                            'errorMessage' => $e->getMessage(),
                            'errors' => $errors,
                            'previousData' => [
                                'name' => $data['name'],
                                'description' => $data['description'],
                            ]
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            },
            [new IsUserAdminMiddleware()]
        );
        $this->router->get(
            $prefix . '/{id}/',
            function (array $slug, ?MiddlewareException  $middleware) {
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
            },
            [new IsUserAdminMiddleware()]
        );

        $this->router->put(
            $prefix . '/{id}/',
            function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                [$errors, $data] = $this->categoryValidationService->validate(
                    $_POST['name'] ?? '',
                    $_POST['description'] ?? ''
                );

                try {
                    if ($errors) {
                        throw new DomainException('One or more fields are invalid');
                    }

                    $this->categoryController->edit($slug['id'], $data['name'], $data['description']);
                    redirect('/admin/categories/');
                } catch (DomainException $e) {
                    $pageData = $this->categoryController->getEditPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'admin/categories/edit',
                        [
                            'errorMessage' => $e->getMessage(),
                            'previousData' => $data,
                            'errors' => $errors,
                            'category' => new Category($slug['id'], $pageData['name'], $pageData['description'], 0),
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            },
            [new IsUserAdminMiddleware()]
        );

        $this->router->delete(
            $prefix . '/{id}/',
            function (array $slug, ?MiddlewareException  $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                try {
                    $this->categoryController->delete($slug['id']);
                    redirect('/admin/categories');
                } catch (DomainException $e) {
                    $pageData = $this->categoryController->getEditPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'admin/categories/edit',
                        [
                            'errorMessage' => $e->getMessage(),
                            'category' => $pageData['category']
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            },
            [new IsUserAdminMiddleware()]
        );
    }
}
