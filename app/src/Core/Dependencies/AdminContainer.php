<?php

namespace Core\Dependencies;

use Controllers\AssetController;
use Controllers\CategoryController;
use Controllers\ImageController;
use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\Asset\AssetSQLiteRepository;
use Repositories\Category\CategorySQLiteRepository;
use Repositories\Image\SQLiteImageRepository;
use Services\Files\FilesystemFilesService;
use Services\Session\SessionService;
use UseCases\Asset\CreateAssetUseCase;
use UseCases\Category\CreateCategoryUseCase;
use UseCases\Asset\DeleteAssetUseCase;
use UseCases\Category\DeleteCategoryUseCase;
use UseCases\Asset\EditAssetUseCase;
use UseCases\Category\EditCategoryUseCase;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetUseCase;
use UseCases\Category\GetAllCategoryUseCase;
use UseCases\Category\GetCategoryUseCase;
use PDO;
use UseCases\Image\CreateImageUseCase;
use UseCases\Image\DeleteImageUseCase;
use UseCases\Image\GetImageUseCase;
use UseCases\Image\UpdateImageUseCase;
use UseCases\Image\GetImagesForAssetUseCase;

class AdminContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(
            CategorySQLiteRepository::class, function () {
                return new CategorySQLiteRepository($this::get(PDO::class));
            }
        );

        $this->set(
            SQLiteImageRepository::class, function () {
                return new SQLiteImageRepository($this::get(PDO::class));
            }
        );

        $this->set(
            AssetSQLiteRepository::class, function () {
                return new AssetSQLiteRepository($this::get(PDO::class));
            }
        );

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
            CreateCategoryUseCase::class, function () {
                return new CreateCategoryUseCase($this::get(CategorySQLiteRepository::class));
            }
        );
        $this->set(
            GetAllCategoryUseCase::class, function () {
                return new GetAllCategoryUseCase($this::get(CategorySQLiteRepository::class));
            }
        );
        $this->set(
            EditCategoryUseCase::class, function () {
                return new EditCategoryUseCase($this::get(CategorySQLiteRepository::class));
            }
        );
        $this->set(
            GetCategoryUseCase::class, function () {
                return new GetCategoryUseCase($this::get(CategorySQLiteRepository::class));
            }
        );

        $this->set(
            DeleteCategoryUseCase::class, function () {
                return new DeleteCategoryUseCase(
                    $this::get(CategorySQLiteRepository::class),
                    $this::get(AssetSQLiteRepository::class)
                );
            }
        );


        $this->set(
            FilesystemFilesService::class, function () {
                return new FilesystemFilesService();
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
            CategoryController::class, function () {
                return new CategoryController(
                    $this::get(CreateCategoryUseCase::class),
                    $this::get(GetAllCategoryUseCase::class),
                    $this::get(EditCategoryUseCase::class),
                    $this::get(GetCategoryUseCase::class),
                    $this::get(DeleteCategoryUseCase::class)
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
    }
	// TODO: refactor it to multiple containers
}
