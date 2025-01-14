<?php

namespace Controllers;

use UseCases\Category\GetTrendingCategoriesUseCase;

class AuthPagesController
{
    public function __construct(private GetTrendingCategoriesUseCase $getTrendingCategoriesUseCase) {}

    /**
     * @return array{ categories: Category[] }
     */
    public function getAuthPageData(): array
    {
        $categories = $this->getTrendingCategoriesUseCase->execute();

        return [
            'categories' => $categories,
        ];
    }
}
