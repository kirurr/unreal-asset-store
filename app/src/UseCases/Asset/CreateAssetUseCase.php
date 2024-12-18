<?php

namespace UseCases\Asset;

use Repositories\Asset\AssetRepositoryInterface;
use Exception;
use RuntimeException;
use Services\Session\SessionInterface;

class CreateAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository,
        private SessionInterface $session,
    ) {
    }
    /**
     * @return int - return asset id
     * @param  array<string> $images
     */
    public function execute(
        string $id, string $name, string $info, string $description, string $preview_image, int $price, int $engine_version, int $category_id
    ): void {
        $user = $this->session->getUser();
        try {
            $this->repository->create(
                $id, $name, $info, $description, $preview_image, $price, $engine_version, $category_id, $user['id']
            );
        } catch (RuntimeException $e) {
            throw new Exception('Unable to create asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
