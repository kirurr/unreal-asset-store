<?php

function renderView(string $view, array $data = []) {
	extract($data, EXTR_SKIP);
	include BASE_PATH . "src/Views/$view.view.php";
	die();
}
