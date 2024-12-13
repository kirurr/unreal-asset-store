<?php

namespace Repositories\Image;

use Entities\Image;

interface ImageRepositoryInterface
{
    public function create(string $path, string $asset_id, int $image_order): void;
    public function update(Image $image): void;
    public function delete(int $id): void;
    /**
     * @return Image[]
     */
    public function getForAsset(string $asset_id): array;
	public function getById(int $id): ?Image;
}
