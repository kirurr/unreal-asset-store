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
        private SessionInterface $session
    ) {
    }
    /**
     * @param array<string> $images
     */
    public function execute(
        string $name, string $info, string $description, array $images, int $price, int $engine_version, int $category_id
    ): void {
        $user = $this->session->getUser();
        try {
            $this->repository->create(
                $name, $info, $description, $images, $price, $engine_version, $category_id, $user['id']
            );
        } catch (RuntimeException $e) {
            throw new Exception('Unable to create asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
