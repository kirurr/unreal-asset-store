<?php

namespace UseCases\Review;

use Repositories\Review\ReviewRepositoryInterface;
use Exception;
use RuntimeException;

class UpdateReviewUseCase
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository,
    ) {}

    /**
     * @throws Exception
     */
    public function execute(
        int $id,
        string $review_content,
        bool $is_positive,
        string $positive,
        string $negative
    ): void {
        try {
            $review= $this->reviewRepository->getById($id);
            $review->review = $review_content;
            $review->is_positive = $is_positive;
            $review->positive = $positive;
            $review->negative = $negative;
            $this->reviewRepository->update($review);
        } catch (RuntimeException $e) {
            throw new Exception("Cannot update review: {$e->getMessage()}");
        }
    }
}
