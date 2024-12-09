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
    public function execute(int $category_id = null): array
    {
        try {
			if ($category_id) {
				return $this->repository->getByCategoryId($category_id);
			}
            return $this->repository->getAll();
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get all assets: ' . $e->getMessage(), 500, $e);
        }
    }
}
