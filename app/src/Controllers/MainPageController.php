<?php

namespace Controllers;

use Services\Session\SessionService;
use UseCases\Asset\GetTopAssetsUseCase;
use UseCases\Asset\GetMainPageAssetsUseCase;
use UseCases\Asset\Variant;

class MainPageController
{
    public function __construct(
        private SessionService $session,
		private GetTopAssetsUseCase $getTopAssetsUseCase,
		private GetMainPageAssetsUseCase $getMainPageAssetsUseCase
    ) {}
    /**
     * @return array{ user: User }
     */
    public function getMainPageData(Variant $moreAssetsVariant): array
    {
		return [
			'user' => $this->session->getUser(),
			'topAssets' => $this->getTopAssetsUseCase->execute(),
			'moreAssets' => $this->getMainPageAssetsUseCase->execute($moreAssetsVariant),
		];
    }
}
