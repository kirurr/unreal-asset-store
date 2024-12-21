<?php

namespace Services\Files;

interface FilesInterface
{
    /**
     * @return string - return path to image
     */
    public function saveImage(string $name, string $tmp_name, string $asset_id): string;
	public function getImage(string $path): string;
	public function deleteImage(string $path): void;

	public function saveFile(string $name, string $tmp_name, string $asset_id): array;
	public function getFile(string $path): string;
	public function deleteFile(string $path): void;
}
