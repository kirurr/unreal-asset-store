<?php

namespace UseCases\Asset;

use Repositories\Asset\AssetRepositoryInterface;
use Exception;

class ChangeAssetPurchaseCountUseCase
{
    public function __construct(
        private AssetRepositoryInterface $assetRepository
    ) {}

    public function execute(string $id, bool $increment = true): void
    {
        $asset = $this->assetRepository->getById($id);
        if (!$asset) {
            throw new Exception('Asset not found');
        }

        if ($increment) {
            $this->assetRepository->incrementPurchasedCount($asset->id);
        } else {
            $this->assetRepository->decrementPurchasedCount($asset->id);
        }
    }
}
