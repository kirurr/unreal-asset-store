<?php

namespace Controllers;

use Services\Session\SessionService;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetsByUserPurhcasesUseCase;
use UseCases\Review\GetReviewsByUserIdUseCase;
use UseCases\User\GetUserUseCase;

class ProfileController
{
    public function __construct(
        private GetUserUseCase $getUserUseCase,
        private GetAllAssetUseCase $getAllAssetUseCase,
		private GetAssetsByUserPurhcasesUseCase $getAssetsByUserPurhcasesUseCase,
		private GetReviewsByUserIdUseCase $getReviewsByUserIdUseCase,
    ) {}

    /**
     * @return array{ user: User, assets: Asset[],}
     */
    public function getProfileData(): array
    {
		$session = SessionService::getInstance();
        $sessionUser = $session->getUser();

        $user = $this->getUserUseCase->execute((int) $sessionUser['id']);
        $assets = $this->getAllAssetUseCase->execute(user_id: $user->id);
        $purchased_assets = $this->getAssetsByUserPurhcasesUseCase->execute($user->id);

		$reviews = $this->getReviewsByUserIdUseCase->execute($user->id);

        return [
            'user' => $user,
            'assets' => $assets,
			'purchased_assets' => $purchased_assets,
			'reviews' => $reviews,
        ];
    }
}
