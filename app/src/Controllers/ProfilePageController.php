<?php

namespace Controllers;

use Services\Session\SessionService;
use UseCases\User\GetUserUseCase;

class ProfilePageController
{
    public function __construct(
        private SessionService $session,
		private GetUserUseCase $getUserUseCase
    ) {}

    public function show(): void
    {
		$session = $this->session->getUser();

		$user = $this->getUserUseCase->execute((int) $session['id']);
        renderView('profile', ['user' => $user]);
    }
}
