<?php

namespace UseCases\Purchase;

use Entities\Purchase;
use Exception;
use Repositories\Purchase\PurchaseRepositoryInterface;
use RuntimeException;

class GetPurchasesUseCase
{
    public function __construct(
        private PurchaseRepositoryInterface $purchaseRepository
    ) {}

    /**
     * @return Purchase[]
     */
    public function execute(): array
    {
        try {
            return $this->purchaseRepository->getAll();
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get purchases: ' . $e->getMessage(), 500, $e);
        }
    }
}
