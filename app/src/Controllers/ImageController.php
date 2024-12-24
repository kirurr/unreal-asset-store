<?php

namespace Controllers;

use Entities\Asset;
use UseCases\Asset\EditAssetUseCase;
use UseCases\Asset\GetAssetUseCase;
use UseCases\Image\CreateImageUseCase;
use UseCases\Image\DeleteImageUseCase;
use UseCases\Image\GetImageUseCase;
use UseCases\Image\GetImagesForAssetUseCase;
use UseCases\Image\UpdateImageUseCase;
use DomainException;

class ImageController
{
    public function __construct(
        private GetImagesForAssetUseCase $getForAssetUseCase,
        private CreateImageUseCase $createUseCase,
        private DeleteImageUseCase $deleteUseCase,
        private UpdateImageUseCase $updateUseCase,
        private GetImageUseCase $getImageUseCase,
        private EditAssetUseCase $editAssetUseCase,
        private GetAssetUseCase $getAssetUseCase
    ) {
    }
    /**
     * @return array{ asset_id: string, images: Image[], asset: Asset }
     */
    public function getMainPageData(string $asset_id): array
    {
        return [
        'asset_id' => $asset_id,
        'images' => $this->getForAssetUseCase->execute($asset_id),
        'asset' => $this->getAssetUseCase->execute($asset_id)
        ];
    }

    public function update(string $asset_id, int $image_id, string $image_name, string $tmp_name, string $image_order, string $old_image_path): void
    {
            $this->updateUseCase->execute($asset_id, $image_id, $image_name, $tmp_name, $image_order, $old_image_path);
    }

    public function updatePreviewImage(string $asset_id, int $image_id): void
    {
        $image = $this->getImageUseCase->execute($image_id);
        $this->editAssetUseCase->execute($asset_id, preview_image: $image->path);
    }
    /**
     * @return array{ asset: Asset }
     */
    public function getEditPageData(string $asset_id): array
    {
        return ['asset' => $this->getAssetUseCase->execute($asset_id)];
    }

    /**
     * @param array{ name: string, tmp_name: string } $images
     */
    public function create(string $asset_id, array $images, int $previous_image_order): void
    {
        if(!$images) {
            throw new DomainException('No images');
        }
        for ($i = 0; $i < count($images['name']); $i++) {
            $path = $this->createUseCase->execute(
                $images['name'][$i], $images['tmp_name'][$i], $asset_id, ($previous_image_order + 1) + $i
            );
        }

    }

    public function delete(string $asset_id, int $image_id): void
    {
        $this->deleteUseCase->execute($image_id);
    }

}
