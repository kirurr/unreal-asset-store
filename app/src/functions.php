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

function generatePagination(int $currentPage, int $totalPages, ?int $maxVisiblePages = 5): array {
    $pagination = [];

    // Определяем границы для отображения страниц
    $half = floor($maxVisiblePages / 2);
    $start = max(1, $currentPage - $half);
    $end = min($totalPages, $currentPage + $half);

    // Добавляем многоточия в начале
    if ($start > 1) {
        $pagination[] = '<';
        if ($start > 2) {
            $pagination[] = '...';
        }
    }

    // Добавляем номера страниц
    for ($i = $start; $i <= $end; $i++) {
		$pagination[] = $i;
    }

    // Добавляем многоточия в конце
    if ($end < $totalPages) {
        if ($end < $totalPages - 1) {
            $pagination[] = '...';
        }
        $pagination[] = '>';
    }

    return $pagination;
}

function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('b', 'kb', 'mb', 'gb', 'tb');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}