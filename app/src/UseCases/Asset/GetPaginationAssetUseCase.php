<?php

namespace UseCases\Asset;

use Entities\AssetFilters;
use Repositories\Asset\AssetRepositoryInterface;

class GetPaginationAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository
    ) {}

	/**
     * @return int return pages count
     */
    public function execute(AssetFilters $filters): int
    {
        $count = $this->repository->countAssets($this->repository->buildQuery($filters, true));
        if (!$filters->limit) {
            $filters->limit = 10;
        }
        $pages = ceil($count / $filters->limit);

        return $pages;
    }
}
