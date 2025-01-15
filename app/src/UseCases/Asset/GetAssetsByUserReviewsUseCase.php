<?php

namespace UseCases\Asset;

use Repositories\Asset\AssetRepositoryInterface;
use Exception;
use RuntimeException;

class GetAssetsByUserReviewsUseCase
{
    public function __construct(
        private AssetRepositoryInterface $assetRepository
    ) {}

    /**
     * @return ?array{ 1: Asset, 2: Review }[]
     */
    public function execute(int $user_id): array
    {
        try {
            return $this->assetRepository->getAssetsByUserReviews($user_id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get assets by user reviews: ' . $e->getMessage(), 500, $e);
        }
    }
}
