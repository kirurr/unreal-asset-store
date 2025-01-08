<?php

namespace Core\Dependencies;

use Controllers\CategoryController;
use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\Asset\AssetSQLiteRepository;
use Services\Validation\CategoryValidationService;
use UseCases\Category\CreateCategoryUseCase;
use UseCases\Category\DeleteCategoryUseCase;
use UseCases\Category\GetAllCategoryUseCase;
use UseCases\Category\EditCategoryUseCase;
use UseCases\Category\GetCategoryUseCase;
use Repositories\Category\CategorySQLiteRepository;
use UseCases\Category\GetTrendingCategoriesUseCase;

class CategoryContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {

        $this->set(
            CategoryValidationService::class, function () {
                return new CategoryValidationService();
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
			GetTrendingCategoriesUseCase::class, function () {
				return new GetTrendingCategoriesUseCase(
					$this::get(CategorySQLiteRepository::class)
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
