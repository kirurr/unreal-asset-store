<?php

namespace Repositories;

use Entities\Test;

interface TestRepository {
	public function getByid(int $id): Test;
}
