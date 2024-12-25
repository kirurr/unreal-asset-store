<?php

namespace UseCases\Asset;

use Entities\Asset;
use Exception;
use Repositories\Asset\AssetRepositoryInterface;
use RuntimeException;


class GetTopAssetsUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository
    ) {
    }
    /**
     * @return ?Asset[]
     */
    public function execute(): array
    {
        try {
            return $this->repository->getAssets(
                limit: 5, byNew: true, byPopular: true, interval: 7
            );
        } catch (RuntimeException $e) {
            throw new Exception(
                'Unable to get top assets: ' . $e->getMessage(), 500, $e
            );
        }
    }
}
