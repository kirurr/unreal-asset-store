<?php

namespace Router\Middlewares;

use Core\Errors\MiddlewareException;
use Services\Session\SessionService;
use UseCases\Asset\GetAssetUseCase;
use UseCases\File\GetFileByIdUseCase;
use UseCases\Purchase\IsUserPurchasedAssetUseCase;

class IsUserPurchasedAssetMiddleware extends Middleware
{
    public function __construct(
        private GetFileByIdUseCase $getFileByIdUseCase,
        private IsUserPurchasedAssetUseCase $isUserPurchasedAssetUseCase,
        private GetAssetUseCase $getAssetUseCase
    ) {}

    public function __invoke(array $slug = []): void
    {
        $asset = $this->getAssetUseCase->execute($slug['id']);

        if (!$asset) {
            throw new MiddlewareException('Asset not found');
        }
        if ($asset->price === 0) {
            return;
        }


		$session = SessionService::getInstance();
        if (!$session->hasUser()) {
            throw new MiddlewareException('User is not logged in');
        };

        if($asset->user_id === $this->session->getUser()['id']) {
			return;
        }

        if (!$this->isUserPurchasedAssetUseCase->execute($asset->id, $this->session->getUser()['id'])) {
            throw new MiddlewareException('User is not purchased asset');
        }


        return;
    }
}
