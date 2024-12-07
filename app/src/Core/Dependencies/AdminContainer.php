<?php

namespace Core\Dependencies;

use Controllers\CategoryController;
use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\Category\CategorySQLiteRepository;
use UseCases\Category\CreateCategoryUseCase;
use UseCases\Category\GetAllCategoryUseCase;
use PDO;

class AdminContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(CategorySQLiteRepository::class, function () {
            return new CategorySQLiteRepository($this->get(PDO::class));
        });

        $this->set(CreateCategoryUseCase::class, function () {
            return new CreateCategoryUseCase($this->get(CategorySQLiteRepository::class));
        });
        $this->set(GetAllCategoryUseCase::class, function () {
            return new GetAllCategoryUseCase($this->get(CategorySQLiteRepository::class));
        });

        $this->set(CategoryController::class, function () {
            return new CategoryController($this->get(CreateCategoryUseCase::class), $this->get(GetAllCategoryUseCase::class));
        });
    }
}
