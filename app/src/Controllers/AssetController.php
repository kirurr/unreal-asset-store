<?php

namespace Controllers;

use Entities\Asset;
use UseCases\Asset\CreateAssetUseCase;
use UseCases\Asset\DeleteAssetUseCase;
use UseCases\Asset\EditAssetUseCase;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetUseCase;
use DomainException;
use Exception;
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
        private GetImagesForAssetUseCase $getImagesForAssetUseCase
    ) {
    }

    public function show(): void
    {
        $assets = $this->getAllUseCase->execute();
        renderView('admin/assets/index', ['assets' => $assets]);
    }

    public function showCreate(): void
    {
        $categories = $this->getAllCategoryUseCase->execute();
        renderView(
            'admin/assets/create', ['categories' => $categories]
        );
    }

    public function showEdit(int $id): void
    {
        try {
            $categories = $this->getAllCategoryUseCase->execute();
            $asset = $this->getUseCase->execute($id);
            renderView('admin/assets/edit', ['asset' => $asset, 'categories' => $categories]);
        } catch (DomainException $e) {
            http_response_code(404);
            header('Location: /admin/assets', true);
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }

        renderView('admin/assets/edit', ['asset' => $asset]);
    }

    public function delete(int $id): void
    {
        try {
            $this->deleteUseCase->execute($id);
        } catch (DomainException $e) {
            http_response_code(400);
            renderView(
                'admin/assets/edit', [
                'errorMessage' => $e->getMessage(),
                ]
            );
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        http_response_code(200);
        header('Location: /admin/assets', true, 303);
    }
    /**
     * @param array<string> $images
     */
    public function edit(int $id, string $name, string $info, string $description, array $images, int $price, int $engine_version, int $category_id): void
    {
        try {
            $this->editUseCase->execute($id, $name, $info, $description, $images, $price, $engine_version, $category_id);
        } catch (DomainException $e) {
            http_response_code(400);
            renderView(
                'admin/assets/edit', [
                'errorMessage' => $e->getMessage(),
                'previousData' => [
                'name' => $name,
                'info' => $info,
                'description' => $description,
                'images' => $images,
                'price' => $price,
                'engine_version' => $engine_version,
                'category_id' => $category_id,
                ],
                'fields' => ['name', 'info', 'description', 'images', 'price', 'engine_version', 'category_id']
                ]
            );
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        http_response_code(200);
        header('Location: /admin/assets', true, 303);
    }
    /**
     * @param array<string> $images
     */
    public function create(string $name, string $info, string $description, array $images, int $price, int $engine_version, int $category_id): void
    {
        try {
            $this->createUseCase->execute($name, $info, $description, $images, $price, $engine_version, $category_id);
        } catch (DomainException $e) {
            http_response_code(400);
            renderView(
                'admin/assets/create', [
                'errorMessage' => $e->getMessage(),
                'previousData' => [
                'name' => $name,
                'info' => $info,
                'description' => $description,
                'images' => Asset::getImagesString($images),
                'price' => $price,
                'engine_version' => $engine_version,
                'category_id' => $category_id,
                ]
                ]
            );
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        http_response_code(201);
        header('Location: /admin/assets', true, 303);
    }

}
