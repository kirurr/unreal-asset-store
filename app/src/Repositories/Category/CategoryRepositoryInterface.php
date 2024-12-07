<?php

namespace Repositories\Category;

use Entities\Category;

interface CategoryRepositoryInterface
{
    public function getById(int $id): ?Category;
    public function getByName(string $name): ?Category;
	/**
	 * @return ?Category[]
	 */
    public function getAll(): ?array;
    public function create(string $name, string $description, string $image): void;
    public function update(Category $category): void;
    public function delete(int $id): void;
}
