<?php

namespace Controllers;

class MainPageController
{
	public function show(): void
	{
		renderView('main');
	}
}
