<?php

namespace Controllers;

use Entities\Purchase;
use UseCases\Purchase\DeletePurchaseUseCase;
use UseCases\Purchase\GetPurchasesUseCase;

class PurchasesController
{
    public function __construct(
        private GetPurchasesUseCase $getPurchasesUseCase,
		private DeletePurchaseUseCase $deletePurchaseUseCase
    ) {}

    /**
     * @return array{ purchases: Purchase[] }
     */
    public function getPurchasesPageData(): array
    {
        return [
            'purchases' => $this->getPurchasesUseCase->execute()
        ];
    }

	public function deletePurchase(string $id): void
	{
		$this->deletePurchaseUseCase->execute($id);
	}
}
