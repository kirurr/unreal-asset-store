<?php

namespace UseCases\Purchase;

use Exception;
use Repositories\Asset\AssetRepositoryInterface;
use Repositories\Purchase\PurchaseRepositoryInterface;
use RuntimeException;
use Services\Session\SessionService;
use DomainException;

class PurchaseAssetUseCase
{
    public function __construct(
        private PurchaseRepositoryInterface $repository,
        private AssetRepositoryInterface $assetRepository,
    ) {}

    public function execute(string $id): void
    {
        try {
            $asset = $this->assetRepository->getById($id);
			$session = SessionService::getInstance();
			$user = $session->getUser();

            if (!$asset) {
                throw new DomainException('Asset not found');
            }

            if ($asset->price === 0) {
                throw new DomainException('Asset is free');
            }

            if (!$user) {
                throw new DomainException('User is not logged in');
            }

            $purchases = $this->repository->getAllByUserId($user['id']);
            foreach ($purchases as $purchase) {
                if ($purchase->asset_id === $id) {
                    throw new DomainException('User already purchased asset');
                }
            }

            $this->repository->create($id, $user['id']);
            $this->assetRepository->incrementPurchasedCount($id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to purchase asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
