<?php

namespace Repositories\Image;

use Entities\Image;

interface ImageRepositoryInterface
{
    public function create(string $path, int $asset_id, int $image_order): Image;
    public function update(Image $image): void;
    public function delete(int $id): void;
    /**
     * @return Image[]
     */
    public function getForAsset(int $asset_id): array;
	public function getById(int $id): ?Image;
}
