<?php

namespace UseCases\Review;

use Entities\Review;
use Repositories\Review\ReviewRepositoryInterface;
use Exception;
use RuntimeException;

class GetReviewByIdUseCase
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository,
    ) {}

    /**
     * @throws Exception
     */
    public function execute(int $id): ?Review
    {
        try {
            return $this->reviewRepository->getById($id);
        } catch (RuntimeException $e) {
            throw new Exception("Cannot get review by id: {$e->getMessage()}");
        }
    }
}
