<?php

namespace Controllers;

use Entities\Category;
use UseCases\Category\GetAllCategoryUseCase;

class CategoriesPageController
{
    public function __construct(private GetAllCategoryUseCase $getCategoriesUseCase)
    {
    }

    /**
     * @return array{ categories: Category[] }
     */
    public function getCategoriesPageData(): array
    {
        $categories = $this->getCategoriesUseCase->execute(true);

        return [
            'categories' => $categories,
        ];
    }
}
