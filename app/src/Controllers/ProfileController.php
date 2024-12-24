<?php

namespace Controllers;

use Services\Session\SessionService;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\User\GetUserUseCase;

class ProfileController
{
    public function __construct(
        private SessionService $session,
        private GetUserUseCase $getUserUseCase,
        private GetAllAssetUseCase $getAllAssetUseCase,
    ) {
    }

    /**
     * @return array{ user: User, assets: Asset[],}
     */
    public function getProfileData(): array
    {
            $session = $this->session->getUser();

            $user = $this->getUserUseCase->execute((int) $session['id']);
            $assets = $this->getAllAssetUseCase->execute(user_id: $user->id);
        return [
        'user' => $user,
        'assets' => $assets
        ];
    }

}

