<?php

namespace Controllers;

use UseCases\Asset\Asset;
use UseCases\Asset\CreateAssetUseCase;
use UseCases\Asset\DeleteAssetUseCase;
use UseCases\Asset\EditAssetUseCase;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetUseCase;
use DomainException;
use UseCases\Category\GetAllCategoryUseCase;
use UseCases\Image\CreateImageUseCase;
use UseCases\Image\GetImagesForAssetUseCase;
use UseCases\Image\DeleteImageUseCase;
use UseCases\Image\UpdateImageUseCase;

class AssetController
{
    public function __construct(
        private CreateAssetUseCase $createUseCase,
        private GetAllAssetUseCase $getAllUseCase,
        private EditAssetUseCase $editUseCase,
        private GetAssetUseCase $getUseCase,
        private DeleteAssetUseCase $deleteUseCase,
        private GetAllCategoryUseCase $getAllCategoryUseCase,
        private CreateImageUseCase $createImageUseCase,
        private UpdateImageUseCase $updateImageUseCase,
        private DeleteImageUseCase $deleteImageUseCase,
        private GetImagesForAssetUseCase $getImagesForAssetUseCase,
    ) {
    }

    /**
     * @return array{ assets: Asset[] }
     */
    public function getAssetsPageData(): array
    {
        return ['assets' => $this->getAllUseCase->execute()];

    }

    /**
     * @return array{ categories: Category[] }
     */
    public function getCreatePageData(): array
    {
        return ['categories' => $this->getAllCategoryUseCase->execute()];
    }

    /**
     * @return array{ asset: Asset, categories: Category[] }
     */
    public function getEditPageData(string $id): array
    {
        return [
        'asset' => $this->getUseCase->execute($id),
        'categories' => $this->getAllCategoryUseCase->execute()
        ];
    }

    public function delete(string $id): void
    {
            $asset = $this->getUseCase->execute($id);
        foreach ($asset->images as $image) {
            $this->deleteImageUseCase->execute($image->id);
        }
            $this->deleteUseCase->execute($id);
    }

    public function edit(string $id, string $name, string $info, string $description, int $price, string $engine_version, int $category_id): void
    {
        $this->editUseCase->execute($id, name: $name, info: $info, description: $description, price: $price, engine_version: $engine_version, category_id: $category_id);
    }

    /**
     * @param array{ name: string, tmp_name: string } $images
     */
    public function create(string $name, string $info, string $description, array $images, int $price, string $engine_version, int $category_id): void
    {
		$asset_id = uniqid();

        if(!$images) {
            throw new DomainException('No images');
        }

		$images_path = [];
        for ($i = 0; $i < count($images['name']); $i++) {
            $path = $this->createImageUseCase->execute(
                $images['name'][$i], $images['tmp_name'][$i], $asset_id, $i
            );
            $images_path[] = $path;
        }
            $preview_image = $images_path[0];
            $this->createUseCase->execute(
                $asset_id, $name, $info, $description, $preview_image, $price, $engine_version, $category_id
			);
    }

}
