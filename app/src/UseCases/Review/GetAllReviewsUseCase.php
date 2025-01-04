<?php

namespace UseCases\Review;

use Exception;
use Repositories\Review\ReviewRepositoryInterface;
use RuntimeException;

class GetAllReviewsUseCase
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository
    ) {}

    /**
     * @return Review[]
     */
    public function execute(): array
    {
        try {
            return $this->reviewRepository->getAll();
        } catch (RuntimeException $e) {
            throw new Exception("Cannot get all reviews: " . $e->getMessage());
        }
    }
}
