<?php

namespace UseCases\User;

use Services\Session\SessionService;

class SignOutUserUseCase
{

    public function execute(): void
    {
		$session = SessionService::getInstance();
		$session->deleteUser();
    }
}
