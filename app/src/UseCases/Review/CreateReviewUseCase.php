<?php

namespace UseCases\Review;

use Repositories\Review\ReviewRepositoryInterface;
use Services\Session\SessionService;
use Exception;
use RuntimeException;

class CreateReviewUseCase
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository,
        private SessionService $sessionService,
    ) {}

    /**
     * @throws Exception
     */
    public function execute(
        string $asset_id,
        string $review,
        string $positive,
        string $negative,
        bool $is_positive
    ): void {
        try {
            $user_id = $this->sessionService->getUser()['id'];

            $this->reviewRepository->create(
                $asset_id,
                $user_id,
                $review,
                $positive,
                $negative,
                $is_positive
            );
        } catch (RuntimeException $e) {
            throw new Exception("Cannot create review: {$e->getMessage()}");
        }
    }
}
