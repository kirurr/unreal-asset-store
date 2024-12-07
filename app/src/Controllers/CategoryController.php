<?php

namespace Controllers;

use UseCases\Category\CreateCategoryUseCase;
use UseCases\Category\DeleteCategoryUseCase;
use UseCases\Category\EditCategoryUseCase;
use UseCases\Category\GetAllCategoryUseCase;
use UseCases\Category\GetCategoryUseCase;
use DomainException;
use Exception;

class CategoryController
{
    public function __construct(
        private CreateCategoryUseCase $createUseCase,
        private GetAllCategoryUseCase $getAllUseCase,
        private EditCategoryUseCase $editUseCase,
		private GetCategoryUseCase $getUseCase,
		private DeleteCategoryUseCase $deleteUseCase
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

    public function showEdit(int $id): void
    {
        try {
            $category = $this->getUseCase->execute($id);
        } catch (DomainException $e) {
            http_response_code(404);
            header('Location: /admin/categories', true);
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }

        renderView('admin/categories/edit', ['category' => $category]);
    }
	
	public function delete(int $id): void
	{
		try {
			$this->deleteUseCase->execute($id);
		} catch (DomainException $e) {
			http_response_code(400);
			renderView('admin/categories/edit', [
				'errorMessage' => $e->getMessage(),
				'previousData' => [
					'name' => $name,
					'description' => $description,
					'image' => $image
				],
				'fields' => ['name', 'description', 'image']
			]);
		} catch (Exception $e) {
			http_response_code(500);
			renderView('error', ['error' => $e->getMessage()]);
		}
		http_response_code(200);
		header('Location: /admin/categories', true, 303);
	}

    public function edit(int $id, string $name, string $description, string $image): void
    {
        try {
            $this->editUseCase->execute($id, $name, $description, $image);
        } catch (DomainException $e) {
            http_response_code(400);
            renderView('admin/categories/edit', [
                'errorMessage' => $e->getMessage(),
                'previousData' => [
                    'name' => $name,
                    'description' => $description,
                    'image' => $image
                ],
                'fields' => ['name', 'description', 'image']
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        http_response_code(200);
        header('Location: /admin/categories', true, 303);
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
