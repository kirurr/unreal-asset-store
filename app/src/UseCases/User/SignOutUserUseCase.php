<?php

namespace UseCases\User;

use Services\Session\SessionInterface;

class SignOutUserUseCase
{
    public function __construct(
        private SessionInterface $session
    ) {}

    public function execute(): void
    {
        $this->session->deleteUser();
    }
}
