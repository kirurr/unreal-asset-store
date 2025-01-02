<?php

namespace UseCases\Purchase;

use Repositories\Purchase\PurchaseRepositoryInterface;
use Exception;
use RuntimeException;

class DeletePurchaseUseCase
{
    public function __construct(
        private PurchaseRepositoryInterface $purchaseRepository
    ) {}

    public function execute(string $id): void
    {
        try {
            $this->purchaseRepository->delete($id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to delete purchase: ' . $e->getMessage(), 500, $e);
        }
    }
}
