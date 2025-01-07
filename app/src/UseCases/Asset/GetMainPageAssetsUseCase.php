<?php

namespace UseCases\Asset;

use Entities\AssetFilters;
use Repositories\Asset\AssetRepositoryInterface;
use Exception;
use RuntimeException;

enum Variant: string
{
    case NEW_TODAY = 'today';
    case NEW_WEEK = 'new-week';
    case NEW_MONTH = 'new-month';
	case POPULAR_WEEK = 'popular-week';
	case POPULAR_MONTH = 'popular-month';
    case POLULAR_ALL_TIME = 'popular-all';
}

class GetMainPageAssetsUseCase
{
    public function __construct(
        private AssetRepositoryInterface $repository
    ) {}

    /**
     * @return ?Asset[]
     */
    public function execute(Variant $variant): array
    {
        try {
            switch ($variant) {
                case Variant::NEW_TODAY:
                    $stmt = $this->repository->buildQuery(new AssetFilters(interval: 1, byNew: true, limit: 8));
                    break;
                case Variant::NEW_WEEK:
                    $stmt = $this->repository->buildQuery(new AssetFilters(interval: 7, byNew: true, limit:8));
                    break;
				case Variant::POPULAR_WEEK:
					$stmt = $this->repository->buildQuery(new AssetFilters(interval: 7, byPopular: true, limit:8));
					break;
                case Variant::NEW_MONTH:
                    $stmt = $this->repository->buildQuery(new AssetFilters(interval: 30, byNew: true, limit:8));
                    break;
				case Variant::POPULAR_MONTH:
					$stmt = $this->repository->buildQuery(new AssetFilters(interval: 30, byPopular: true, limit:8));
					break;
                case Variant::POLULAR_ALL_TIME:
                    $stmt = $this->repository->buildQuery(new AssetFilters(byPopular: true, limit:8));
                    break;
            }

            return $this->repository->getAssets($stmt);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get assets for main page: ' . $e->getMessage(), 500, $e);
        }
    }
}
