<?php

namespace UseCases\Asset;

use Entities\Asset;
use Entities\AssetFilters;
use Exception;
use Repositories\Asset\AssetRepositoryInterface;
use RuntimeException;

class GetAssetsPageUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository
    ) {
    }
    /**
     * @return ?Asset[]
     */
    public function execute(AssetFilters $filters): array
    {
        try {
            return $this->repository->getAssets(
                category_id: $filters->category_id,
                user_id: $filters->user_id,
                search: $filters->search,
                engine_version: $filters->engine_version,
                interval: $filters->interval,
                byNew: $filters->byNew,
                byPopular: $filters->byPopular,
                asc: $filters->asc,
                minPrice: $filters->minPrice,
                maxPrice: $filters->maxPrice,
                limit: $filters->limit
            );
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get assets: ' . $e->getMessage(), 500, $e);
        }
    }
}
