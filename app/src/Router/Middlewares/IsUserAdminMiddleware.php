<?php

namespace Router\Middlewares;

use Core\Errors\MiddlewareException;
use Services\Session\SessionInterface;

class IsUserAdminMiddleware extends Middleware
{
    public function __construct(
        private SessionInterface $session
    ) {}

    public function __invoke(array $slug = []): void
    {
        $user = $this->session->getUser();
        if (!$user) {
            throw new MiddlewareException('User is not logged in');
        }
        if ($user['role'] !== 'admin') {
            throw new MiddlewareException('User is not admin');
        }
        return;
    }
}
