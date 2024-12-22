<?php

namespace Core\Dependencies;
use Core\ContainerInterface;

use Repositories\Asset\AssetSQLiteRepository;
use Repositories\Image\SQLiteImageRepository;
use Core\ServiceContainer;
use Services\Session\SessionService;
use UseCases\Asset\CreateAssetUseCase;
use UseCases\Asset\DeleteAssetUseCase;
use UseCases\Asset\EditAssetUseCase;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetUseCase;

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

    }
}
