<?php

namespace Repositories;

use Entities\Test;

interface TestRepositoryInterface {
	public function getByid(int $id): Test;
}
