<?php

namespace Controllers;

use UseCases\Image\CreateImageUseCase;
use UseCases\Image\DeleteImageUseCase;
use UseCases\Image\UpdateImageUseCase;
use DomainException;
use Exception;

class ImageController
{
    public function __construct(
        private CreateImageUseCase $createUseCase,
        private DeleteImageUseCase $deleteUseCase,
        private UpdateImageUseCase $updateUseCase
    ) {
    }

}
