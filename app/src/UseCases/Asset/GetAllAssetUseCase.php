<?php

namespace UseCases\Asset;

use Entities\AssetFilters;
use Repositories\Asset\AssetRepositoryInterface;
use Exception;
use RuntimeException;

class GetAllAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository
    ) {}

    /**
     * @return Asset[]
     */
    public function execute(int $category_id = null, int $user_id = null): array
    {
        try {
            $stmt = $this->repository->buildQuery(new AssetFilters(category_id: $category_id, user_id: $user_id));
            return $this->repository->getAssets($stmt);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get assets: ' . $e->getMessage(), 500, $e);
        }
    }
}
