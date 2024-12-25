<?php

namespace UseCases\Asset;

use Exception;
use Repositories\Asset\AssetRepositoryInterface;
use RuntimeException;

class GetAllAssetUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository
    ) {
    }


    /**
     * @return Asset[]
     */
    public function execute(int $category_id = null, int $user_id = null): array
    {
        try {
			return $this->repository->getAssets(category_id: $category_id, user_id: $user_id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get assets: ' . $e->getMessage(), 500, $e);
        }
    }
}
