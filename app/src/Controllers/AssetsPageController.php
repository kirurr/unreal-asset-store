<?php

namespace Controllers;

use Entities\AssetFilters;
use Entities\File;
use UseCases\Asset\ChangeAssetPurchaseCountUseCase;
use UseCases\Asset\GetAssetsPageUseCase;
use UseCases\Asset\GetAssetUseCase;
use UseCases\Asset\GetPaginationAssetUseCase;
use UseCases\Category\GetAllCategoryUseCase;
use UseCases\Category\GetCategoryUseCase;
use UseCases\Category\GetTrendingCategoriesUseCase;
use UseCases\File\GetFileByIdUseCase;
use UseCases\File\GetFilesUseCase;
use UseCases\Purchase\PurchaseAssetUseCase;
use UseCases\Review\CreateReviewUseCase;
use UseCases\Review\GetReviewsByAssetIdUseCase;
use UseCases\User\GetUserUseCase;

class AssetsPageController
{
    public function __construct(
        private GetAllCategoryUseCase $getAllCategoryUseCase,
        private GetAssetsPageUseCase $getAssetsPageUseCase,
        private GetAssetUseCase $getAssetUseCase,
        private GetCategoryUseCase $getCategoryUseCase,
        private GetFilesUseCase $getFilesUseCase,
        private GetFileByIdUseCase $getFileUseCase,
        private ChangeAssetPurchaseCountUseCase $changeAssetPurchaseCountUseCase,
        private PurchaseAssetUseCase $purchaseAssetUseCase,
        private GetReviewsByAssetIdUseCase $getReviewsByAssetIdUseCase,
		private CreateReviewUseCase $createReviewUseCase,
		private GetPaginationAssetUseCase $getPaginationAssetUseCase,
		private GetUserUseCase $getUserUseCase,
		private GetTrendingCategoriesUseCase $getTrendingCategoriesUseCase
    ) {}

    /**
     * @return array{ assets: Asset[] }
     */
    public function getAssetsPageData(AssetFilters $filters): array
    {
		if ($filters->user_id) {
			$user = $this->getUserUseCase->execute($filters->user_id);
		}
        return [
            'assets' => $this->getAssetsPageUseCase->execute($filters),
			'pages' => $this->getPaginationAssetUseCase->execute($filters),
            'categories' => $this->getAllCategoryUseCase->execute(),
			'user' => $user ?? null
        ];
    }

    /**
     * @return array{ asset: Asset, category: Category, reviews: Review[] user: array }
     */
    public function getAssetPageData(string $id): array
    {
        $asset = $this->getAssetUseCase->execute($id);
        $category = $this->getCategoryUseCase->execute($asset->category->id);
        $reviews = $this->getReviewsByAssetIdUseCase->execute($id);

        return [
            'asset' => $asset,
            'category' => $category,
            'reviews' => $reviews,
			'trendingCategories' => $this->getTrendingCategoriesUseCase->execute(),
        ];
    }

    /**
     * @return array{ asset: Asset, category: Category, files: File[] }
     */
    public function getFilesPageData(string $id): array
    {
        $asset = $this->getAssetUseCase->execute($id);
        $category = $this->getCategoryUseCase->execute($asset->category_id);
        $files = $this->getFilesUseCase->execute($id);

        return [
            'asset' => $asset,
            'category' => $category,
            'files' => $files,
        ];
    }

    public function getFileForDownload(string $id, string $file_id): ?File
    {
        return $this->getFileUseCase->execute($file_id);
    }

    public function changeAssetPurchaseCount(string $id, bool $increment): void
    {
        $this->changeAssetPurchaseCountUseCase->execute($id, $increment);
    }

    /**
     * @return array{ asset: Asset }
     */
    public function getPurchasePageData(string $id): array
    {
        $asset = $this->getAssetUseCase->execute($id);

        return [
            'asset' => $asset,
        ];
    }

    public function purchaseAsset(string $id): void
    {
        $this->purchaseAssetUseCase->execute($id);
    }

	public function createReview(string $id, string $title, string $review, bool $is_positive, string $positive, string $negative): void
	{
		$this->createReviewUseCase->execute($id, $title, $review, $positive, $negative, $is_positive);
	}
}
