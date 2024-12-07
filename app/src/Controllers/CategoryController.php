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
        // # TODO: handle all errors
    }

    public function showCreate(): void
    {
        renderView(
            'admin/categories/create'
        );
    }

    public function create(): void
    {
        $name = htmlspecialchars($_POST['name'] ?? '');
        $description = htmlspecialchars($_POST['description'] ?? '');
        $image = htmlspecialchars($_POST['image'] ?? '');

        try {
            $this->createUseCase->execute($name, $description, $image);
            http_response_code(201);
        } catch (Exception $e) {
            http_response_code(500);
            echo 'internal server error';
            die();
        } catch (DomainException $e) {
            http_response_code(400);
            echo 'invalid request';
            die();
        }

        echo 'category created';
        die();
        header('Location: /');
    }
}
