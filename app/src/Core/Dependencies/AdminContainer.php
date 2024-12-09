<?php

namespace Core\Dependencies;

use Controllers\AssetController;
use Controllers\CategoryController;
use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\Asset\AssetSQLiteRepository;
use Repositories\Category\CategorySQLiteRepository;
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
                return new GetAssetUseCase($this::get(AssetSQLiteRepository::class));
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
            AssetController::class, function () {
                return new AssetController(
                    $this::get(CreateAssetUseCase::class),
                    $this::get(GetAllAssetUseCase::class),
                    $this::get(EditAssetUseCase::class),
                    $this::get(GetAssetUseCase::class),
                    $this::get(DeleteAssetUseCase::class),
                    $this::get(GetAllCategoryUseCase::class)
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
    }
}
