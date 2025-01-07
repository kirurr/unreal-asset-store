<?php

namespace UseCases\Asset;

use Entities\Asset;
use Entities\AssetFilters;
use Repositories\Asset\AssetRepositoryInterface;
use Exception;
use RuntimeException;

class GetAssetsPageUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository
    ) {}

    /**
     * @return ?Asset[]
     */
    public function execute(AssetFilters $filters): array
    {
        try {
            $stmt = $this->repository->buildQuery($filters);
            return $this->repository->getAssets($stmt);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get assets: ' . $e->getMessage(), 500, $e);
        }
    }
}
