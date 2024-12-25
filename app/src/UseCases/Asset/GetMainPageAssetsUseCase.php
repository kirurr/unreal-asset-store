<?php

namespace UseCases\Asset;

use Exception;
use Repositories\Asset\AssetRepositoryInterface;
use RuntimeException;

enum Variant: string
{
    case NEW_TODAY = 'today';
    case NEW_WEEK = 'week';
    case NEW_MONTH = 'month';
    case POLULAR_ALL_TIME = 'popular';
}

class GetMainPageAssetsUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository
    ) {
    }

    
    /**
     * @return ?Asset[]
     */
    public function execute(Variant $variant): array
    {
        try {
            switch ($variant) {
            case Variant::NEW_TODAY:
                return $this->repository->getAssets(interval: 1, byNew: true);
                break;
            case Variant::NEW_WEEK:
                return $this->repository->getAssets(interval: 7, byNew: true);
            break;
            case Variant::NEW_MONTH:
                return $this->repository->getAssets(interval: 30, byNew: true);
            break;
            case Variant::POLULAR_ALL_TIME:
                return $this->repository->getAssets(byPopular: true);
            break;
            }
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get assets for main page: ' . $e->getMessage(), 500, $e);
        }
    }
}
