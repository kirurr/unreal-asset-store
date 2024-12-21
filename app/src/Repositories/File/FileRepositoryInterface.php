<?php

namespace Repositories\File;

use Entities\File;

interface FileRepositoryInterface
{
    public function create(string $name, string $path, string $version, string $description, string $asset_id, int $size): void;
    public function update(File $file): void;
    public function delete(string $id): void;
    public function findById(string $id): ?File;
    /**
     * @return File[]
     */
    public function findAllByAssetId(string $asset_id): array;
}
