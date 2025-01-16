<?php

namespace Router\Routes\Profile;

use Controllers\ProfileController;
use Core\Errors\MiddlewareException;
use Core\ServiceContainer;
use DomainException;
use Exception;
use Router\Middlewares\IsUserMiddleware;
use Router\Middlewares\IsUserReviewAuthorMiddleware;
use Router\Router;
use Router\Routes\RoutesInterface;

use Router\Routes\Routes;
use Services\Validation\ReviewValidationService;
use UseCases\Review\GetReviewByIdUseCase;

class MainProfileRoutes extends Routes implements RoutesInterface
{
    private ProfileController $profileController;
    private ReviewValidationService $reviewValidationService;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->reviewValidationService = ServiceContainer::get(ReviewValidationService::class);
        $this->profileController = ServiceContainer::get(ProfileController::class);
    }

    public function defineRoutes(string $prefix = ''): void
    {
        $this->router->get(
            $prefix . '/',
            function (array $slug, ?MiddlewareException $middlware) {
                if ($middlware) {
                    redirect('/');
                }

                $asset = $_GET['assets'] ?? "created";
                $data = $this->profileController->getProfileData($asset);
                try {
                    renderView('profile/index', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            },
            [(new IsUserMiddleware())]
        );

        $this->router->get(
            $prefix . '/reviews/{id}/',
            function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                };


                $data =  $this->profileController->getReviewEditPageData($slug['id']);
                try {
                    renderView('profile/reviews/edit', $data);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            },
            [(new IsUserReviewAuthorMiddleware(ServiceContainer::get(GetReviewByIdUseCase::class)))]
        );

        $this->router->put(
            $prefix . '/reviews/{id}/',
            function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                };
                [$errors, $data] = $this->reviewValidationService->validate(
                    $_POST['title'] ?? '',
                    $_POST['review'] ?? '',
                    $_POST['is_positive'] ?? '',
                    $_POST['positive'] ?? '',
                    $_POST['negative'] ?? '',
                );

                try {
                    if ($errors) {
                        throw new DomainException('One or more fields are incorrect');
                    }

                    $this->profileController->updateReview(
                        $slug['id'],
                        $data['title'],
                        $data['review'],
                        $data['positive'],
                        $data['negative'],
                        $data['is_positive']
                    );
                    redirect('/profile#reviews');
                } catch (DomainException $e) {
                    $pageData =  $this->profileController->getReviewEditPageData($slug['id']);
                    renderView('profile/reviews/edit', [
                        'review' => $pageData['review'],
                        'errors' => $errors,
                        'previousData' => $data,
                        'errorMessage' => $e->getMessage()
                    ]);
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            },
            [(new IsUserReviewAuthorMiddleware(ServiceContainer::get(GetReviewByIdUseCase::class)))]
        );

        $this->router->delete(
            $prefix . '/reviews/{id}/',
            function (array $slug, ?MiddlewareException $middleware) {
                if ($middleware) {
                    redirect('/');
                };

                try {
                    $this->profileController->deleteReview($slug['id']);
                    redirect('/profile#reviews');
                } catch (Exception $e) {
                    $this->handleException($e);
                }
            },
            [(new IsUserReviewAuthorMiddleware(ServiceContainer::get(GetReviewByIdUseCase::class)))]
        );
    }
}
