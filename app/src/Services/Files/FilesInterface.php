<?php

namespace Services\Files;

interface FilesInterface
{
    /**
     * @return string - return path to image
     */
    public function saveImage(string $path, array $file, int $asset_id): string;
	public function getImage(string $path): string;
	public function deleteImage(string $path): void;
}
