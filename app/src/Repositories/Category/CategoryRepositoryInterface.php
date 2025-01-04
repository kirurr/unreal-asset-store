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
    public function getAll(bool $by_popular = false): array;
    public function create(string $name, string $description): void;
    public function update(Category $category): void;
    public function delete(int $id): void;
	public function incrementAssetCount(int $id): void;
	public function decrementAssetCount(int $id): void;
}
