<?php

namespace UseCases\Asset;

use Repositories\Asset\AssetRepositoryInterface;
use DomainException;
use Exception;
use RuntimeException;

class DeleteAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository
    ) {}

    public function execute(int $id): void
    {
        try {
            $asset = $this->repository->getById($id);
            if (!$asset) {
                throw new DomainException('Asset not found');
            }
            $this->repository->delete($id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to delete asset: ' . $e->getMessage(), 500, $e);
        }
    }
}