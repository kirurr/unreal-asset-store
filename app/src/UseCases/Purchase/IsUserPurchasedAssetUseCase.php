<?php

namespace UseCases\Purchase;

use Exception;
use Repositories\Purchase\PurchaseRepositoryInterface;
use RuntimeException;

class IsUserPurchasedAssetUseCase
{
    public function __construct(
        private PurchaseRepositoryInterface $purchaseRepository
    ) {}

    public function execute(string $asset_id, int $user_id): bool
    {
        try {
            $user_purchases = $this->purchaseRepository->getAllByUserId($user_id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get purchases: ' . $e->getMessage(), 500, $e);
        }
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
