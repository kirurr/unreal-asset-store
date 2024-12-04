<?php

namespace Controllers;

use Services\Session\SessionService;

class MainPageController
{
    public function __construct(
        private SessionService $session
    ) {}

    public function show(): void
    {
        renderView('main', ['user' => $this->session->getUser()]);
    }
}
