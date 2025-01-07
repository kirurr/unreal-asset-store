<?php

namespace Router\Middlewares;

use Core\Errors\MiddlewareException;
use Services\Session\SessionService;

class IsUserAdminMiddleware extends Middleware
{
    public function __invoke(array $slug = []): void
    {
		$session = SessionService::getInstance();
        $user = $session->getUser();
        if (!$user) {
            throw new MiddlewareException('User is not logged in');
        }
        if ($user['role'] !== 'admin') {
            throw new MiddlewareException('User is not admin');
        }
        return;
    }
}
