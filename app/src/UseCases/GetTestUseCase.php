<?php

namespace UseCases;

use Repositories\TestRepositoryInterface;
use Entities\Test;

class GetTestUseCase
{
	public function __construct(private TestRepositoryInterface $repository) {}

	public function execute(int $id): Test {
		return $this->repository->getById($id);
	}
}
