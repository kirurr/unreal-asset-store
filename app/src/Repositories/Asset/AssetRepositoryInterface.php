<?php

namespace Repositories\Asset;

use Entities\Asset;

interface AssetRepositoryInterface
{
    public function getById(int $id): ?Asset;
    /**
     * @return ?Asset[]
     */
    public function getAll(): array;
    public function getByCategoryId(int $category_id): array;
    /**
     * @param array<string> $images
     */
    public function create(string $name, string $info, string $description, array $images, int $price, int $engine_version, int $category_id, int $user_id): void;
    public function update(Asset $asset): void;
    public function delete(int $id): void;
}
