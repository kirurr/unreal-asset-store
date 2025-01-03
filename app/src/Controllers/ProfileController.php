<?php

namespace Controllers;

use Services\Session\SessionService;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetsByUserPurhcasesUseCase;
use UseCases\User\GetUserUseCase;

class ProfileController
{
    public function __construct(
        private SessionService $session,
        private GetUserUseCase $getUserUseCase,
        private GetAllAssetUseCase $getAllAssetUseCase,
        private GetAssetsByUserPurhcasesUseCase $getAssetsByUserPurhcasesUseCase
    ) {}

    /**
     * @return array{ user: User, assets: Asset[],}
     */
    public function getProfileData(): array
    {
        $session = $this->session->getUser();

        $user = $this->getUserUseCase->execute((int) $session['id']);
        $assets = $this->getAllAssetUseCase->execute(user_id: $user->id);
        $purchased_assets = $this->getAssetsByUserPurhcasesUseCase->execute($user->id);

        return [
            'user' => $user,
            'assets' => $assets,
            'purchased_assets' => $purchased_assets
        ];
    }
}
