<?php

namespace UseCases\Asset;

use Entities\Asset;
use DomainException;
use Exception;
use Repositories\Asset\AssetRepositoryInterface;
use RuntimeException;

class GetAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository    
    ) {
    }

    public function execute(int $id): Asset
    {
        try {
            $asset = $this->repository->getById($id);
            if (!$asset) {
                throw new DomainException('Asset not found');
            }
            return $asset;
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get Asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
