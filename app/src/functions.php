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
        return $previousData[$name] === 0 ? '' : $previousData[$name];
    } elseif (isset($object->$name)) {
        return $object->{$name} === 0 ? '' : $object->{$name};
    }
	return '';
}

function generatePagination(int $currentPage, int $totalPages, ?int $maxVisiblePages = 5): array {
    $pagination = [];
    $half = floor($maxVisiblePages / 2);
    $start = max(1, $currentPage - $half);
    $end = min($totalPages, $currentPage + $half);
    if ($start > 1) {
        $pagination[] = '<';
        if ($start > 2) {
            $pagination[] = '...';
        }
    }
    for ($i = $start; $i <= $end; $i++) {
		$pagination[] = $i;
    }
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
