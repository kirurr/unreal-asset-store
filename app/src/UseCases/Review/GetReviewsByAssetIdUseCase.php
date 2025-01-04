<?php

namespace UseCases\Review;

use Repositories\Review\ReviewRepositoryInterface;
use Exception;
use RuntimeException;

class GetReviewsByAssetIdUseCase
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository
    ) {}

    /**
     * @return Review[]
     */
    public function execute(string $asset_id): array
    {
        try {
            return $this->reviewRepository->getAllByAssetId($asset_id);
        } catch (RuntimeException $e) {
            throw new Exception("Cannot get all reviews by asset: {$e->getMessage()}", 500, $e);
        }
    }
}
