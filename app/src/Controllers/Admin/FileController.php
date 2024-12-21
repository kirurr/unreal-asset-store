<?php

namespace Controllers\Admin;

use Exception;
use UseCases\File\CreateFileUseCase;
use UseCases\File\GetFilesUseCase;

class FileController
{
    public function __construct(
        private GetFilesUseCase $getFilesUseCase,
        private CreateFileUseCase $createUseCase
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
}
