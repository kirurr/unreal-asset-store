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

function retrieveData(array $previousData, mixed $object, string $name): mixed
{
    if (isset($previousData[$name])) {
        return $previousData[$name];
    } elseif (isset($object->$name)) {
        return $object->{$name};
    }
	return '';
}
