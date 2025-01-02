<?php

namespace Core\Dependencies;

use Controllers\PurchasesController;
use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\Asset\AssetSQLiteRepository;
use Repositories\Purchase\SQLitePurchaseRepository;
use Services\Session\SessionService;
use UseCases\Purchase\DeletePurchaseUseCase;
use UseCases\Purchase\GetPurchasesUseCase;
use UseCases\Purchase\IsUserPurchasedAssetUseCase;
use UseCases\Purchase\PurchaseAssetUseCase;
use PDO;

class PurchaseContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(SQLitePurchaseRepository::class, function () {
            return new SQLitePurchaseRepository($this::get(PDO::class));
        });

        $this->set(GetPurchasesUseCase::class, function () {
            return new GetPurchasesUseCase($this::get(SQLitePurchaseRepository::class));
        });

        $this->set(DeletePurchaseUseCase::class, function () {
            return new DeletePurchaseUseCase($this::get(SQLitePurchaseRepository::class));
        });

        $this->set(PurchaseAssetUseCase::class, function () {
            return new PurchaseAssetUseCase(
                $this::get(SessionService::class),
                $this::get(SQLitePurchaseRepository::class),
                $this::get(AssetSQLiteRepository::class),
            );
        });

        $this->set(IsUserPurchasedAssetUseCase::class, function () {
            return new IsUserPurchasedAssetUseCase($this::get(SQLitePurchaseRepository::class));
        });

		$this->set(PurchasesController::class, function () {
			return new PurchasesController(
				$this::get(GetPurchasesUseCase::class),
				$this::get(DeletePurchaseUseCase::class)
			);
		});
    }
}
