<?php

function renderView(string $view, array $data = []) {
	extract($data, EXTR_SKIP);
	require BASE_PATH . "src/Views/$view.view.php";
	die();
}

function renderComponent(string $component, array $data = []) {
	extract($data, EXTR_SKIP);
	require BASE_PATH . "src/Views/components/$component.view.php";
}

function redirect(string $url) {
	header('Location: ' . $url, true);
	die();
}
