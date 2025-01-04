<?php

namespace UseCases\Review;

use Repositories\Review\ReviewRepositoryInterface;
use Exception;
use RuntimeException;

class DeleteReviewUseCase
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository,
    ) {}

    /**
     * @throws Exception
     */
    public function execute(int $id): void
    {
        try {
            $this->reviewRepository->delete($id);
        } catch (RuntimeException $e) {
            throw new Exception("Cannot delete review: {$e->getMessage()}");
        }
    }
}
