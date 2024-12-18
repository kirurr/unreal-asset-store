<?php

namespace Router\Middlewares;

use Core\Errors\MiddlewareException;
use Services\Session\SessionInterface;

class IsUserMiddleware extends Middleware
{
    public function __construct(
        private SessionInterface $session
    ) {}

    public function __invoke(array $slug = []): void
    {
		if($this->session->hasUser()) {
			return;
		};
		throw new MiddlewareException('User is not logged in');
    }
}
