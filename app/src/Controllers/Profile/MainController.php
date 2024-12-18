<?php

namespace Controllers\Profile;

use Exception;
use Services\Session\SessionService;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\User\GetUserUseCase;

class MainController
{
    public function __construct(
        private SessionService $session,
        private GetUserUseCase $getUserUseCase,
        private GetAllAssetUseCase $getAllAssetUseCase,
    ) {
    }

    public function show(): void
    {
        try 
        {
            $session = $this->session->getUser();

            $user = $this->getUserUseCase->execute((int) $session['id']);
            $assets = $this->getAllAssetUseCase->execute(user_id: $user->id);
            renderView('profile/index', ['user' => $user, 'assets' => $assets]);
        } 
        catch (Exception $e) 
        {
            renderView('error', ['message' => $e->getMessage()]);
        }
    }

}

