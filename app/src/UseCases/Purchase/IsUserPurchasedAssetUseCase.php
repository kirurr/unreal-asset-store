<?php

namespace UseCases\Purchase;

use Repositories\Purchase\PurchaseRepositoryInterface;

class IsUserPurchasedAssetUseCase
{
    public function __construct(
        private PurchaseRepositoryInterface $purchaseRepository
    ) {}

    public function execute(string $asset_id, int $user_id): bool
    {
        $user_purchases = $this->purchaseRepository->getAllByUserId($user_id);
        if (!$user_purchases) {
            return false;
        }

        foreach ($user_purchases as $purchase) {
            if ($purchase->asset_id === $asset_id) {
                return true;
            }
        }
        return false;
    }
}
