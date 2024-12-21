<?php

namespace Repositories\Asset;

use Entities\Asset;

interface AssetRepositoryInterface
{
    public function getById(string $id): ?Asset;
    /**
     * @return ?Asset[]
     */
    public function getAll(): array;
    /**
     * @return ?Asset[]
     */
    public function getByCategoryId(string $category_id): array;
    /**
     * @return ?Asset[]
     */
    public function getByUserId(string $user_id): array;
    public function create(string $id, string $name, string $info, string $description, string $preview_image, int $price, string $engine_version, int $category_id, int $user_id): void;
    public function update(Asset $asset): void;
    public function delete(string $id): void;
}
