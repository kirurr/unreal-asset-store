<?php

namespace Controllers;

use UseCases\Category\CreateCategoryUseCase;
use UseCases\Category\GetAllCategoryUseCase;
use DomainException;
use Exception;

class CategoryController
{
    public function __construct(
        private CreateCategoryUseCase $createUseCase,
        private GetAllCategoryUseCase $getAllUseCase
    ) {}

    public function show(): void
    {
        $categories = $this->getAllUseCase->execute();
        renderView('admin/categories/index', ['categories' => $categories]);
    }

    public function showCreate(): void
    {
        renderView(
            'admin/categories/create'
        );
    }

    public function create(string $name, string $description, string $image): void
    {
        try {
            $this->createUseCase->execute($name, $description, $image);
        } catch (DomainException $e) {
            http_response_code(400);
            renderView('admin/categories/create', [
                'errorMessage' => $e->getMessage(),
                'previousData' => [
                    'name' => $name,
                    'description' => $description,
                    'image' => $image
                ]
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        http_response_code(201);
        header('Location: /admin/categories', true, 303);
    }
}
