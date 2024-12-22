<?php

namespace Core\Dependencies;

use Core\ContainerInterface;
use Core\ServiceContainer;

use Controllers\Admin\FileController;
use Controllers\Admin\AssetController;
use Controllers\Admin\ImageController;

use UseCases\Asset\CreateAssetUseCase;
use UseCases\Asset\DeleteAssetUseCase;
use UseCases\Asset\EditAssetUseCase;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetUseCase;
use UseCases\File\DeleteFileUseCase;
use UseCases\File\GetFileByIdUseCase;
use UseCases\File\CreateFileUseCase;
use UseCases\File\UpdateFileUseCase;
use UseCases\File\GetFilesUseCase;
use UseCases\Image\CreateImageUseCase;
use UseCases\Image\GetImageUseCase;
use UseCases\Image\GetImagesForAssetUseCase;
use UseCases\Image\UpdateImageUseCase;
use UseCases\Image\DeleteImageUseCase;
use UseCases\Category\GetAllCategoryUseCase;

class AdminContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(
            AssetController::class, function () {
                return new AssetController(
                    $this::get(CreateAssetUseCase::class),
                    $this::get(GetAllAssetUseCase::class),
                    $this::get(EditAssetUseCase::class),
                    $this::get(GetAssetUseCase::class),
                    $this::get(DeleteAssetUseCase::class),
                    $this::get(GetAllCategoryUseCase::class),
                    $this::get(CreateImageUseCase::class),
                    $this::get(UpdateImageUseCase::class),
                    $this::get(DeleteImageUseCase::class),
                    $this::get(GetImagesForAssetUseCase::class)
                );
            }
        );

        $this->set(
            ImageController::class, function () {
                return new ImageController(
                    $this::get(GetImagesForAssetUseCase::class),
                    $this::get(CreateImageUseCase::class),
                    $this::get(DeleteImageUseCase::class),
                    $this::get(UpdateImageUseCase::class),
                    $this::get(GetImageUseCase::class),
                    $this::get(EditAssetUseCase::class),
                    $this::get(GetAssetUseCase::class)
                );
            }
        );

        $this->set(
            FileController::class, function () {
                return new FileController(
                    $this::get(GetFilesUseCase::class),
                    $this::get(CreateFileUseCase::class),
                    $this::get(GetFileByIdUseCase::class),
                    $this::get(UpdateFileUseCase::class),
                    $this::get(DeleteFileUseCase::class)
                );
            }
        );
    }
}
