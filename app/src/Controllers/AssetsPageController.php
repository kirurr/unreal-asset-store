<?php

namespace Controllers;

use Entities\AssetFilters;
use Entities\File;
use Services\Session\SessionService;
use UseCases\Asset\ChangeAssetPurchaseCountUseCase;
use UseCases\Asset\GetAssetsPageUseCase;
use UseCases\Asset\GetAssetUseCase;
use UseCases\Category\GetAllCategoryUseCase;
use UseCases\Category\GetCategoryUseCase;
use UseCases\File\GetFileByIdUseCase;
use UseCases\File\GetFilesUseCase;
use UseCases\Purchase\PurchaseAssetUseCase;

class AssetsPageController
{
    public function __construct(
        private GetAllCategoryUseCase $getAllCategoryUseCase,
        private GetAssetsPageUseCase $getAssetsPageUseCase,
        private GetAssetUseCase $getAssetUseCase,
        private GetCategoryUseCase $getCategoryUseCase,
        private SessionService $sessionService,
        private GetFilesUseCase $getFilesUseCase,
        private GetFileByIdUseCase $getFileUseCase,
        private ChangeAssetPurchaseCountUseCase $changeAssetPurchaseCountUseCase,
		private PurchaseAssetUseCase $purchaseAssetUseCase
    ) {}

    /**
     * @return array{ assets: Asset[] }
     */
    public function getAssetsPageData(AssetFilters $filters): array
    {
        return [
            'assets' => $this->getAssetsPageUseCase->execute($filters),
            'categories' => $this->getAllCategoryUseCase->execute()
        ];
    }

    /**
     * @return array{ asset: Asset, category: Category, user: array }
     */
    public function getAssetPageData(string $id): array
    {
        $asset = $this->getAssetUseCase->execute($id);
        $category = $this->getCategoryUseCase->execute($asset->category_id);

        return [
            'asset' => $asset,
            'category' => $category,
            'user' => $this->sessionService->getUser()
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
            'user' => $this->sessionService->getUser()
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
}
