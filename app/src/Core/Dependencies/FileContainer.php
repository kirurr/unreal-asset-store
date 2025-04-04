<?php

namespace Core\Dependencies;

use Controllers\FileController;
use Core\ContainerInterface;

use Core\ServiceContainer;
use UseCases\Asset\GetAssetUseCase;
use UseCases\Category\GetTrendingCategoriesUseCase;
use UseCases\File\CreateFileUseCase;
use Services\Files\FilesystemFilesService;
use UseCases\File\DeleteFileUseCase;
use UseCases\File\GetFileByIdUseCase;
use Repositories\File\SQLiteFileRepository;
use UseCases\File\UpdateFileUseCase;
use UseCases\File\GetFilesUseCase;

class FileContainer extends ServiceContainer implements ContainerInterface {
    public function initDependencies(): void
    {
        $this->set(
            GetFilesUseCase::class, function () {
                return new GetFilesUseCase($this::get(SQLiteFileRepository::class));
            }
        );

        $this->set(
            CreateFileUseCase::class, function () {
                return new CreateFileUseCase($this::get(SQLiteFileRepository::class), $this::get(FilesystemFilesService::class));
            }
        );

        $this->set(
            GetFileByIdUseCase::class, function () {
                return new GetFileByIdUseCase($this::get(SQLiteFileRepository::class));
            }
        );

        $this->set(
            UpdateFileUseCase::class, function () {
                return new UpdateFileUseCase($this::get(SQLiteFileRepository::class), $this::get(FilesystemFilesService::class));
            }
        );

		$this->set(DeleteFileUseCase::class, function () {
			return new DeleteFileUseCase($this::get(SQLiteFileRepository::class), $this->get(FilesystemFilesService::class));
		});

        $this->set(
            FileController::class, function () {
                return new FileController(
                    $this::get(GetFilesUseCase::class),
                    $this::get(CreateFileUseCase::class),
                    $this::get(GetFileByIdUseCase::class),
                    $this::get(UpdateFileUseCase::class),
                    $this::get(DeleteFileUseCase::class),
                    $this::get(GetTrendingCategoriesUseCase::class),
					$this::get(GetAssetUseCase::class)
                );
            }
        );
    }

}
