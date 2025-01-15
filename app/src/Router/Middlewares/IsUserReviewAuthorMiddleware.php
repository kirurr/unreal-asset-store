<?php

namespace Router\Middlewares;

use Core\Errors\MiddlewareException;
use Services\Session\SessionService;
use UseCases\Review\GetReviewByIdUseCase;

class IsUserReviewAuthorMiddleware extends Middleware
{
    public function __construct(
        private GetReviewByIdUseCase $getReviewByIdUseCase
    ) {
    }

    public function __invoke(array $slug = []): void
    {
		$session = SessionService::getInstance();
        if(!$session->hasUser()) {
            throw new MiddlewareException('User is not logged in');
        };
        $review = $this->getReviewByIdUseCase->execute($slug['id']);

        if (!$review) {
            throw new MiddlewareException('Review not found');
        }

        if($review->user->id !== $session->getUser()['id']) {
            throw new MiddlewareException('User is not author of review');
        }

        return;
    }
}   