<?php

namespace Controllers;

use Entities\AssetFilters;
use UseCases\Asset\GetAssetsPageUseCase;
use UseCases\Category\GetAllCategoryUseCase;

class AssetsPageController
{
    public function __construct(
        private GetAllCategoryUseCase $getAllCategoryUseCase,
        private GetAssetsPageUseCase $getAssetsPageUseCase
    ) {
    }

    /**
     * @return array{ assets: Asset[] }
     */
    public function getAssetsPageData(AssetFilters $filters): array
    {
		return [
			'assets' => $this->getAssetsPageUseCase->execute($filters),
			'categories' => $this->getAllCategoryUseCase->execute()
		];
    }

}
