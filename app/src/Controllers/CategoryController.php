<?php

namespace Controllers;

use Entities\Category;
use UseCases\Category\CreateCategoryUseCase;
use UseCases\Category\DeleteCategoryUseCase;
use UseCases\Category\EditCategoryUseCase;
use UseCases\Category\GetAllCategoryUseCase;
use UseCases\Category\GetCategoryUseCase;

class CategoryController
{
    public function __construct(
        private CreateCategoryUseCase $createUseCase,
        private GetAllCategoryUseCase $getAllUseCase,
        private EditCategoryUseCase $editUseCase,
        private GetCategoryUseCase $getUseCase,
        private DeleteCategoryUseCase $deleteUseCase
    ) {
    }

    /**
     * @return array{ categories: Category[]}
     */
    public function getCategoryPageData(): array
    {
        return ['categories' => $this->getAllUseCase->execute()];
    }

    /**
     * @return array{ category: Category}
     */
    public function getEditPageData(int $id): array
    {
            return ['category' => $this->getUseCase->execute($id)];
    }

    public function delete(int $id): void
    {
            $this->deleteUseCase->execute($id);
    }

    public function edit(int $id, string $name, string $description): void
    {
        $this->editUseCase->execute($id, $name, $description);
    }

    public function create(string $name, string $description): void
    {
        $this->createUseCase->execute($name, $description);
    }
}
