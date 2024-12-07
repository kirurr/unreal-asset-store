<?php

namespace Repositories\Category;

interface CategoryRepositoryInterface
{
    public function getById(int $id): ?array;
    public function getByName(string $name): array|false;
    public function getAll(): ?array;
    public function create(string $name, string $description, string $image): void;
    public function update(int $id, string $name, string $description, string $image): void;
    public function delete(int $id): void;
}
