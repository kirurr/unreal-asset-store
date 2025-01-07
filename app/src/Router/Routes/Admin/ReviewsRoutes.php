<?php

namespace Router\Routes\Admin;

use Controllers\ReviewController;
use Core\Errors\MiddlewareException;
use Core\ServiceContainer;
use Router\Middlewares\IsUserAdminMiddleware;
use Router\Routes\Routes;
use Router\Routes\RoutesInterface;
use Router\Router;
use Services\Validation\ReviewValidationService;
use DomainException;
use Exception;

class ReviewsRoutes extends Routes implements RoutesInterface
{
    private ReviewController $reviewController;
    private ReviewValidationService $reviewValidationService;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->reviewController = ServiceContainer::get(ReviewController::class);
        $this->reviewValidationService = ServiceContainer::get(ReviewValidationService::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $data = $this->reviewController->getReviewsPageData();
                    renderView('admin/reviews/index', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware()]
        );

        $this->router->get(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $data = $this->reviewController->getReviewPageData($slug['id']);
                    renderView('admin/reviews/edit', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware()]
        );

        $this->router->put(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }

                [$errors, $data] = $this->reviewValidationService->validate(
                    $_POST['review'] ?? '',
                    $_POST['is_positive'] ?? '',
                    $_POST['positive'] ?? '',
                    $_POST['negative'] ?? ''
                );
                try {
                    if ($errors) {
                        throw new DomainException('One or more fields are invalid');
                    }

                    $this->reviewController->updateReview($slug['id'], $data['review'], $data['is_positive'], $data['positive'], $data['negative']);
                    redirect('/admin/reviews');
                } catch (DomainException $e) {
                    $pageData = $this->reviewController->getReviewPageData($slug['id']);
                    http_response_code(400);
                    renderView(
                        'admin/reviews/edit', [
                            'review' => $pageData['review'],
                            'previousData' => [
                                'review' => $data['review'],
                                'is_positive' => $data['is_positive'],
                                'positive' => $data['positive'],
                                'negative' => $data['negative']
                            ],
                            'errorMessage' => $e->getMessage(),
                            'errors' => $errors
                        ]
                    );
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware()]
        );

        $this->router->delete(
            $prefix . '/{id}/', function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                }
                try {
                    $this->reviewController->deleteReview($slug['id']);
                    redirect('/admin/reviews/');
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            }, [new IsUserAdminMiddleware()]
        );
    }
}
