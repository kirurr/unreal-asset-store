<?php

namespace Router\Middlewares;
use Core\Errors\MiddlewareException;
use Services\Session\SessionService;
use UseCases\Asset\GetAssetUseCase;

class IsUserAssetAuthorMiddleware extends Middleware
{
    public function __construct(
        private GetAssetUseCase $getAssetUseCase
    ) {
    }

    public function __invoke(array $slug = []): void
    {
		$session = SessionService::getInstance();
        if(!$session->hasUser()) {
            throw new MiddlewareException('User is not logged in');
        };

        $asset = $this->getAssetUseCase->execute($slug['id']);
		if (!$asset) {
			throw new MiddlewareException('Asset not found');
		}

        if($asset->user->id !== $session->getUser()['id']) {
            throw new MiddlewareException('User is not author of asset');
        }

        return;
    }
}
