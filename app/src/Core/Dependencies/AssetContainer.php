<?php

namespace Core\Dependencies;
use Controllers\Admin\AssetController;
use Controllers\Admin\FileController;
use Controllers\Admin\ImageController;
use Core\ContainerInterface;

use Repositories\Asset\AssetSQLiteRepository;
use Repositories\File\SQLiteFileRepository;
use Repositories\Image\SQLiteImageRepository;
use Core\ServiceContainer;
use Services\Files\FilesystemFilesService;
use Services\Session\SessionService;
use UseCases\Asset\CreateAssetUseCase;
use UseCases\Asset\DeleteAssetUseCase;
use UseCases\Asset\EditAssetUseCase;
use UseCases\Category\GetAllCategoryUseCase;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\File\CreateFileUseCase;
use UseCases\File\GetFilesUseCase;
use UseCases\Image\CreateImageUseCase;
use UseCases\Asset\GetAssetUseCase;
use UseCases\Image\GetImageUseCase;
use UseCases\Image\DeleteImageUseCase;
use UseCases\Image\UpdateImageUseCase;
use UseCases\Image\GetImagesForAssetUseCase;

class AssetContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {

        $this->set(
            CreateAssetUseCase::class, function () {
                return new CreateAssetUseCase($this::get(AssetSQLiteRepository::class), $this->get(SessionService::class));
            }
        );
        $this->set(
            GetAllAssetUseCase::class, function () {
                return new GetAllAssetUseCase($this::get(AssetSQLiteRepository::class));
            }
        );
        $this->set(
            EditAssetUseCase::class, function () {
                return new EditAssetUseCase($this::get(AssetSQLiteRepository::class));
            }
        );
        $this->set(
            GetAssetUseCase::class, function () {
                return new GetAssetUseCase($this::get(AssetSQLiteRepository::class), $this::get(SQLiteImageRepository::class));
            }
        );
        $this->set(
            DeleteAssetUseCase::class, function () {
                return new DeleteAssetUseCase($this::get(AssetSQLiteRepository::class));
            }
        );

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
					$this::get(GetAssetUseCase::class)
				);
			}	
		);

		$this->set(
			GetFilesUseCase::class, function () {
				return new GetFilesUseCase($this::get(SQLiteFileRepository::class));
			}
		);

		$this->set(CreateFileUseCase::class, function () {
			return new CreateFileUseCase($this::get(SQLiteFileRepository::class), $this::get(FilesystemFilesService::class));
		});

		$this->set(
			FileController::class, function () {
				return new FileController(
					$this::get(GetFilesUseCase::class),
					$this::get(CreateFileUseCase::class)
				);
			}
		);
	}
}
