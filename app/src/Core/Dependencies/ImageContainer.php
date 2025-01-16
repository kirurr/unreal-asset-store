<?php

namespace Core\Dependencies;
use Controllers\ImageController;
use Core\ContainerInterface;

use Core\ServiceContainer;
use Services\Files\FilesystemFilesService;
use UseCases\Asset\EditAssetUseCase;
use UseCases\Asset\GetAssetUseCase;
use UseCases\Category\GetTrendingCategoriesUseCase;
use UseCases\Image\CreateImageUseCase;
use Repositories\Image\SQLiteImageRepository;
use UseCases\Image\GetImageUseCase;
use UseCases\Image\DeleteImageUseCase;
use UseCases\Image\UpdateImageUseCase;;
use UseCases\Image\GetImagesForAssetUseCase;

class ImageContainer extends ServiceContainer implements ContainerInterface {
    public function initDependencies(): void
    {
        $this->set(
            GetImagesForAssetUseCase::class, function () {
                return new GetImagesForAssetUseCase($this::get(SQLiteImageRepository::class), $this::get(FilesystemFilesService::class));
            }
        );

        $this->set(
            CreateImageUseCase::class, function () {
                return new CreateImageUseCase($this::get(SQLiteImageRepository::class), $this::get(FilesystemFilesService::class));
            }
        );
        $this->set(
            UpdateImageUseCase::class, function () {
                return new UpdateImageUseCase($this::get(SQLiteImageRepository::class), $this::get(FilesystemFilesService::class));
            }
        );
        $this->set(
            DeleteImageUseCase::class, function () {
                return new DeleteImageUseCase($this::get(SQLiteImageRepository::class), $this::get(FilesystemFilesService::class));
            }
        );
        $this->set(
            GetImageUseCase::class, function () {
                return new GetImageUseCase($this::get(SQLiteImageRepository::class), $this::get(FilesystemFilesService::class));
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
					$this::get(GetAssetUseCase::class),
					$this::get(GetTrendingCategoriesUseCase::class)
                );
            }
        );
    }

}
