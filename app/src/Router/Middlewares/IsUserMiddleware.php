<?php

namespace Router\Middlewares;

use Core\Errors\MiddlewareException;
use Services\Session\SessionService;

class IsUserMiddleware extends Middleware
{
    public function __invoke(array $slug = []): void
    {
		$session = SessionService::getInstance();
		if($session->hasUser()) {
			return;
		};
		throw new MiddlewareException('User is not logged in');
    }
}
