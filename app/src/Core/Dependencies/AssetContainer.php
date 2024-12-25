<?php

namespace Core\Dependencies;
use Controllers\AssetController;
use Core\ContainerInterface;

use Repositories\Asset\AssetSQLiteRepository;
use Repositories\Category\CategorySQLiteRepository;
use Repositories\Image\SQLiteImageRepository;
use Core\ServiceContainer;
use Services\Session\SessionService;
use UseCases\Asset\CreateAssetUseCase;
use UseCases\Asset\DeleteAssetUseCase;
use UseCases\Asset\EditAssetUseCase;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetUseCase;
use UseCases\Asset\GetAssetsPageUseCase;
use UseCases\Asset\GetMainPageAssetsUseCase;
use UseCases\Asset\GetTopAssetsUseCase;
use UseCases\Image\CreateImageUseCase;
use UseCases\Image\GetImagesForAssetUseCase;
use UseCases\Image\UpdateImageUseCase;
use UseCases\Image\DeleteImageUseCase;
use UseCases\Category\GetAllCategoryUseCase;

class AssetContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {

        $this->set(
            CreateAssetUseCase::class, function () {
                return new CreateAssetUseCase(
                    $this::get(AssetSQLiteRepository::class),
                    $this::get(CategorySQLiteRepository::class),
                    $this::get(SessionService::class)
                );
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
                return new DeleteAssetUseCase($this::get(AssetSQLiteRepository::class), $this::get(CategorySQLiteRepository::class));
            }
        );

        $this->set(
            GetTopAssetsUseCase::class, function () {
                return new GetTopAssetsUseCase($this::get(AssetSQLiteRepository::class));
            }
        );

        $this->set(
            GetMainPageAssetsUseCase::class, function () {
                return new GetMainPageAssetsUseCase($this::get(AssetSQLiteRepository::class));
            }
        );

		$this->set(
			GetAssetsPageUseCase::class, function () {
				return new GetAssetsPageUseCase($this::get(AssetSQLiteRepository::class));
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
                    $this::get(GetImagesForAssetUseCase::class),
					$this->get(SessionService::class),
                );
            }
        );
    }
}
