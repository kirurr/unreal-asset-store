<?php

namespace Controllers;

use UseCases\Asset\EditAssetUseCase;
use UseCases\Asset\GetAssetUseCase;
use UseCases\Image\CreateImageUseCase;
use UseCases\Image\DeleteImageUseCase;
use UseCases\Image\GetImageUseCase;
use UseCases\Image\GetImagesForAssetUseCase;
use UseCases\Image\UpdateImageUseCase;
use DomainException;
use Exception;

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

    public function show(string $asset_id): void
    {
        $images = $this->getForAssetUseCase->execute($asset_id);
        $asset = $this->getAssetUseCase->execute($asset_id);

        renderView('admin/assets/images/index', ['images' => $images, 'asset_id' => $asset_id, 'asset' => $asset]);
    }

    public function update(string $asset_id, int $image_id, string $image_name, string $tmp_name, string $image_order, string $old_image_path): void
    {
        try {
            $this->updateUseCase->execute($asset_id, $image_id, $image_name, $tmp_name, $image_order, $old_image_path);
        } catch (DomainException $e) {
            http_response_code(400);
            renderView(
                'admin/assets/images/index', [
                'errorMessage' => $e->getMessage(),
                'asset_id' => $asset_id,
                ]
            );
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        header('Location: /admin/assets/' . $asset_id . '/images/', true);
        die();
    }

    public function updatePreviewImage(string $asset_id, int $image_id): void
    {
        try {
            $image = $this->getImageUseCase->execute($image_id);
            $this->editAssetUseCase->execute($asset_id, preview_image: $image->path);
            header('Location: /admin/assets/' . $asset_id . '/images/', true);
            die();
        } catch (DomainException $e) {
            $asset = $this->getAssetUseCase->execute($asset_id);
            http_response_code(400);
            renderView(
                'admin/assets/images/index', [
                'errorMessage' => $e->getMessage(),
                'asset_id' => $asset_id,
                'asset' => $asset,
                ]
            );
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
    }
    public function create(string $asset_id, array $images, int $previous_image_order): void
    {
        try {
            if(!$images) {
                throw new DomainException('No images');
            }
            for ($i = 0; $i < count($images['name']); $i++) {
                $path = $this->createUseCase->execute(
                    $images['name'][$i], $images['tmp_name'][$i], $asset_id, ($previous_image_order + 1) + $i
                );
            }
        } catch (DomainException $e) {
            $asset = $this->getAssetUseCase->execute($asset_id);
            http_response_code(400);
            renderView(
                'admin/assets/images/index', [
                'errorMessage' => $e->getMessage(),
                'asset_id' => $asset_id,
                'asset' => $asset,
                ]
            );
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        http_response_code(201);
        header('Location: /admin/assets/' . $asset_id . '/images/', true, 303);

    }

	public function delete(string $asset_id, int $image_id): void
	{
		try {
			$this->deleteUseCase->execute($image_id);
		} catch (DomainException $e) {
			$asset = $this->getAssetUseCase->execute($asset_id);
			http_response_code(400);
			renderView(
				'admin/assets/images/index', [
				'errorMessage' => $e->getMessage(),
				'asset_id' => $asset_id,
				'asset' => $asset,
				]
			);
		} catch (Exception $e) {
			http_response_code(500);
			renderView('error', ['error' => $e->getMessage()]);
		}
		http_response_code(204);
		header('Location: /admin/assets/' . $asset_id . '/images/', true, 303);
	}

}
