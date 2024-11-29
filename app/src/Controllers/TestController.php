<?php

namespace Controllers;

use UseCases\GetTestUseCase;

class TestController
{
	public function __construct(private GetTestUseCase $useCase) {}

	public function get(int $id): void
	{
		$test = $this->useCase->execute($id);

		if ($test) {
			echo $test->getText();
		} else {
			echo "no";
		}
	}
}
