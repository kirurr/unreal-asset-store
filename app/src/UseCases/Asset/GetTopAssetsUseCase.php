<?php

namespace UseCases\Asset;

use Entities\Asset;
use Entities\AssetFilters;
use Repositories\Asset\AssetRepositoryInterface;
use Exception;
use RuntimeException;

class GetTopAssetsUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository
    ) {}

    /**
     * @return ?Asset[]
     */
    public function execute(): array
    {
        try {
            $stmt = $this->repository->buildQuery(new AssetFilters(byNew: true, byPopular: true, interval: 7, limit: 5));
            return $this->repository->getAssets($stmt);
        } catch (RuntimeException $e) {
            throw new Exception(
                'Unable to get top assets: ' . $e->getMessage(), 500, $e
            );
        }
    }
}
