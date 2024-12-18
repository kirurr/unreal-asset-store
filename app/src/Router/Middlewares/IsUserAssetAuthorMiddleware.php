<?php

namespace Router\Middlewares;
use Core\Errors\MiddlewareException;

use Services\Session\SessionInterface;
use UseCases\Asset\GetAssetUseCase;

class IsUserAssetAuthorMiddleware extends Middleware
{
    public function __construct(
        private SessionInterface $session,
        private GetAssetUseCase $getAssetUseCase
    ) {
    }

    public function __invoke(array $slug = []): void
    {
        if(!$this->session->hasUser()) {
            throw new MiddlewareException('User is not logged in');
        };

        $asset = $this->getAssetUseCase->execute($slug['id']);
        if($asset->user_id !== $this->session->getUser()['id']) {
            throw new MiddlewareException('User is not author of asset');
        }

        return;
    }
}
