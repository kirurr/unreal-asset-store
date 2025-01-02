<?php

namespace UseCases\Asset;

use Repositories\Asset\AssetRepositoryInterface;
use Exception;
use RuntimeException;

class GetAssetsByUserPurhcasesUseCase
{
    public function __construct(
        private AssetRepositoryInterface $assetRepository
    ) {}

    /**
     * @return ?Asset[]
     */
    public function execute(int $user_id): array
    {
        try {
            return $this->assetRepository->getAssetsByUserPurchases($user_id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get assets by user purchases: ' . $e->getMessage(), 500, $e);
        }
    }
}
