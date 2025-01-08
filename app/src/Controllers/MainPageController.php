<?php

namespace Controllers;

use UseCases\Asset\GetTopAssetsUseCase;
use UseCases\Asset\GetMainPageAssetsUseCase;
use UseCases\Asset\Variant;
use UseCases\Category\GetTrendingCategoriesUseCase;

class MainPageController
{
    public function __construct(
		private GetTopAssetsUseCase $getTopAssetsUseCase,
		private GetMainPageAssetsUseCase $getMainPageAssetsUseCase,
		private GetTrendingCategoriesUseCase $getTrendingCategoriesUseCase
    ) {}
    /**
     * @return array{ user: User }
     */
    public function getMainPageData(Variant $moreAssetsVariant): array
    {
		return [
			'trendingCategories' => $this->getTrendingCategoriesUseCase->execute(),
			'topAssets' => $this->getTopAssetsUseCase->execute(),
			'moreAssets' => $this->getMainPageAssetsUseCase->execute($moreAssetsVariant),
		];
    }
}
