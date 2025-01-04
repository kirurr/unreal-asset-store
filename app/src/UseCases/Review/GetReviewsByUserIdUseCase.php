<?php

namespace UseCases\Review;

use Entities\Review;
use Repositories\Review\ReviewRepositoryInterface;
use Exception;
use RuntimeException;

class GetReviewsByUserIdUseCase
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository,
    ) {}

    /**
	 * @throws Exception
	 * @return Review[]
     */
    public function execute(int $user_id): array
    {
        try {
            return $this->reviewRepository->getAllByUserId($user_id);
        } catch (RuntimeException $e) {
            throw new Exception("Cannot get reviews by user id: {$e->getMessage()}");
        }
    }
}
