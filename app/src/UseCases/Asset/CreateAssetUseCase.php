<?php

namespace UseCases\Asset;

use Repositories\Asset\AssetRepositoryInterface;
use Exception;
use Repositories\Category\CategoryRepositoryInterface;
use RuntimeException;
use Services\Session\SessionService;

class CreateAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository,
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }
    /**
     * @return int - return asset id
     * @param  array<string> $images
     */
    public function execute(
        string $id, string $name, string $info, string $description, string $preview_image, int $price, string $engine_version, int $category_id
    ): void {
		$session = SessionService::getInstance();
        $user = $session->getUser();
        try {
            $this->repository->create(
                $id, $name, $info, $description, $preview_image, $price, $engine_version, $category_id, $user['id']
            );
            $this->categoryRepository->incrementAssetCount($category_id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to create asset: ' . $e->getMessage(), 500, $e);
        }
    }
}
