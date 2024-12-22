<?php

namespace Controllers\Admin;

use DomainException;
use Exception;
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
		private DeleteFileUseCase $deleteFileUseCase
    ) {
    }

    public function show(string $id): void
    {    
        try {
            $files = $this->getFilesUseCase->execute($id);
            renderView('admin/assets/files/index', ['files' => $files, 'asset_id' => $id]);
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        } 
    }
    
    public function showCreate(string $id): void
    {    
        try {
            renderView('admin/assets/files/create', ['asset_id' => $id]);
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        } 
    }

    public function create(string $asset_id, string $name, string $version, string $description, string $file_name, string $path): void
    {    
        try {
            $this->createUseCase->execute($asset_id, $name, $version, $description, $file_name, $path);
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        } 
        http_response_code(201);
        header("Location: /admin/assets/$asset_id/files", true, 303);
    }

    public function showEdit(string $asset_id, string $file_id): void
    {
        try {
            $file = $this->getFileByIdUseCase->execute($file_id);
            renderView('admin/assets/files/edit', ['file' => $file, 'asset_id' => $asset_id]);
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        } 
    }

    public function update(string $asset_id, string $file_id, string $name, string $version, string $description, string $file_name, string $path, string $old_path): void
    {
        try {
            $this->updateFileUseCase->execute($file_id, $asset_id, $name, $version, $description, $file_name, $path, $old_path);
        } catch (DomainException $e) {
            $file = $this->getFileByIdUseCase->execute($file_id);
            http_response_code(400);
            renderView('admin/assets/files/edit', ['file' => $file, 'asset_id' => $asset_id, 'errorMessage' => $e->getMessage()]);
        } catch (Exception $e) {
            http_response_code(500);
            renderView('error', ['error' => $e->getMessage()]);
        }
        http_response_code(201);
        header("Location: /admin/assets/$asset_id/files", true, 303);
    }

	public function delete(string $asset_id, string $file_id): void
	{
		try {
			$this->deleteFileUseCase->execute($file_id);
		} catch (Exception $e) {
			http_response_code(500);
			renderView('error', ['error' => $e->getMessage()]);
		}
		http_response_code(201);
		header("Location: /admin/assets/$asset_id/files", true, 303);
	}
}
