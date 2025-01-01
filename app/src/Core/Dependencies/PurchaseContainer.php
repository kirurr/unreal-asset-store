<?php

namespace Core\Dependencies;

use Core\ContainerInterface;
use Core\ServiceContainer;
use PDO;
use Repositories\Purchase\SQLitePurchaseRepository;
use UseCases\Purchase\IsUserPurchasedAssetUseCase;

class PurchaseContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
		$this->set(SQLitePurchaseRepository::class, function () {
			return new SQLitePurchaseRepository($this::get(PDO::class));
		});

		$this->set(IsUserPurchasedAssetUseCase::class, function () {
			return new IsUserPurchasedAssetUseCase($this::get(SQLitePurchaseRepository::class));
		});
    }
}
