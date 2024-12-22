<?php

namespace UseCases\File;

use DomainException;
use Exception;
use Entities\File;
use Repositories\File\FileRepositoryInterface;

class GetFileByIdUseCase
{
	public function __construct(
		private FileRepositoryInterface $fileRepository
	) {
	}

	public function execute(string $id): File
	{
		try {
			$file = $this->fileRepository->getById($id);
			if (!$file) {
				throw new DomainException('File not found');
			}
			return $file;
		} catch (Exception $e) {
			throw new Exception('Unable to get file: ' . $e->getMessage(), 500, $e);
		}
	}
}
