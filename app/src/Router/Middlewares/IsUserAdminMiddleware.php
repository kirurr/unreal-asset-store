<?php

namespace Router\Middlewares;

use Core\Errors\Error;
use Core\Errors\ErrorCode;
use Services\Session\SessionInterface;

class IsUserAdminMiddleware extends Middleware
{
    public function __construct(
        private SessionInterface $session
    ) {}

    public function __invoke(): ?Error
    {
        $user = $this->session->getUser();
        if (!user) {
            return new Error('User is not logged in', ErrorCode::NOT_AUTHORIZED);
        }
        if ($user['role'] !== 'admin') {
            return new Error('User is not admin', ErrorCode::NOT_AUTHORIZED);
        }
        return null;
    }
}
