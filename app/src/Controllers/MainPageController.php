<?php

namespace Controllers;

use Services\Session\SessionService;

class MainPageController
{
    public function __construct(
        private SessionService $session
    ) {}
    /**
     * @return array{ user: User }
     */
    public function getMainPageData(): array
    {
		return ['user' => $this->session->getUser()];
    }
}
