<?php

namespace Controllers;

use Entities\File;
use UseCases\Asset\GetAssetUseCase;
use UseCases\Category\GetTrendingCategoriesUseCase;
use UseCases\File\CreateFileUseCase;
use UseCases\File\DeleteFileUseCase;
use UseCases\File\GetFileByIdUseCase;
use UseCases\File\GetFilesUseCase;
use UseCases\File\UpdateFileUseCase;

class FileController
{
    public function __construct(
        private GetFilesUseCase $getFilesUseCase,
        private CreateFileUseCase $createUseCase,
        private GetFileByIdUseCase $getFileByIdUseCase,
        private UpdateFileUseCase $updateFileUseCase,
        private DeleteFileUseCase $deleteFileUseCase,
		private GetTrendingCategoriesUseCase $getTrendingCategoriesUseCase,
		private GetAssetUseCase $getAssetUseCase
    ) {
    }

    /**
     * @return array{ files: File[], categories: Category[], asset: Asset }
     */
    public function getMainPageData(string $id): array
    {    
		return [
			'files' => $this->getFilesUseCase->execute($id),
			'asset' => $this->getAssetUseCase->execute($id),
			'categories' => $this->getTrendingCategoriesUseCase->execute(),
		];
    }
    
    public function create(string $asset_id, string $name, string $version, string $description, string $file_name, string $path): void
    {    
		$this->createUseCase->execute($asset_id, $name, $version, $description, $file_name, $path);
    }

    /**
     * @return array{ file: File }
     */
    public function getEditPageData(string $asset_id, string $file_id): array
    {
		return [
			'file' => $this->getFileByIdUseCase->execute($file_id),
			'asset' => $this->getAssetUseCase->execute($asset_id),
			'categories' => $this->getTrendingCategoriesUseCase->execute(),
		];
    }

    public function update(string $asset_id, string $file_id, string $name, string $version, string $description, string $file_name, string $path, string $old_path): void
    {
		$this->updateFileUseCase->execute($file_id, $asset_id, $name, $version, $description, $file_name, $path, $old_path);
    }

    public function delete(string $asset_id, string $file_id): void
    {
		$this->deleteFileUseCase->execute($file_id);
    }
}
