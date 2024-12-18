<?php

namespace Core\Dependencies;

use Core\ContainerInterface;
use Core\ServiceContainer;

use Controllers\Profile\AssetController;
use Controllers\Profile\ImageController;
use Controllers\Profile\MainController;

use Services\Session\SessionService;
use UseCases\Asset\CreateAssetUseCase;
use UseCases\Asset\DeleteAssetUseCase;
use UseCases\Asset\EditAssetUseCase;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetUseCase;
use UseCases\Image\CreateImageUseCase;
use UseCases\Image\GetImageUseCase;
use UseCases\Image\GetImagesForAssetUseCase;
use UseCases\Image\UpdateImageUseCase;
use UseCases\Image\DeleteImageUseCase;
use UseCases\Category\GetAllCategoryUseCase;
use UseCases\User\GetUserUseCase;

class ProfileContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(
            MainController::class, function () {
                return new MainController(
                    $this::get(SessionService::class),
                    $this::get(GetUserUseCase::class),
                    $this::get(GetAllAssetUseCase::class),
                );
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
}
