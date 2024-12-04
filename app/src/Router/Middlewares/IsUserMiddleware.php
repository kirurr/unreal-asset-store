<?php

namespace Router\Middlewares;

use Core\Errors\Error;
use Core\Errors\ErrorCode;
use Services\Session\SessionInterface;

class IsUserMiddleware extends Middleware
{
    public function __construct(
        private SessionInterface $session
    ) {}

    public function __invoke(): ?Error
    {
        if (!$this->session->hasUser()) {
            return new Error('User is not logged in', ErrorCode::NOT_AUTHORIZED);
        }
        return null;
    }
}
