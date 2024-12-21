<?php

namespace UseCases\File;

use Repositories\File\FileRepositoryInterface;
use Exception;
use RuntimeException;

class GetFilesUseCase
{
    public function __construct(
        private FileRepositoryInterface $repository,
    ) {
    }
    /**
     * @return File[]
     */
    public function execute(string $id): array
    {
        try {
            return $this->repository->findAllByAssetId($id);
        } catch (RuntimeException $e) {
            throw new Exception('Unable to get files: ' . $e->getMessage(), 500, $e);
        }
    }
}
