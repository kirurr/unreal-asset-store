<?php

namespace UseCases;

use Repositories\TestRepository;
use Entities\Test;

class GetTestUseCase
{
	public function __construct(private TestRepository $repository) {}

	public function execute(int $id): Test {
		return $this->repository->getById($id);
	}
}
