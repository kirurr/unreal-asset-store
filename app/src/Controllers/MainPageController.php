<?php

namespace Controllers;

use UseCases\Asset\GetTopAssetsUseCase;
use UseCases\Asset\GetMainPageAssetsUseCase;
use UseCases\Asset\Variant;

class MainPageController
{
    public function __construct(
		private GetTopAssetsUseCase $getTopAssetsUseCase,
		private GetMainPageAssetsUseCase $getMainPageAssetsUseCase
    ) {}
    /**
     * @return array{ user: User }
     */
    public function getMainPageData(Variant $moreAssetsVariant): array
    {
		return [
			'topAssets' => $this->getTopAssetsUseCase->execute(),
			'moreAssets' => $this->getMainPageAssetsUseCase->execute($moreAssetsVariant),
		];
    }
}
