<?php
/** @var int $pages */
$myQuery = '';
foreach ($_GET as $key => $value) {
    if ($key !== 'page') {
        $myQuery .= '&' . $key . '=' . $value;
    }
}
$currentPage = intval($_GET['page'] ?? 1);
$pagination = generatePagination($currentPage, $pages);
?>

<?php if ($pages > 1): ?>
<nav aria-label="Page navigation example" class="mt-8 size-fit mx-auto">
	<ul class="flex items-center gap-2 -space-x-px h-10 text-base w-fit">
		<?php foreach ($pagination as $page): ?>
		<?php if ($page === '<'): ?>
			<li>
				<a href="/assets?<?= $myQuery ?>&page=1" class="hover:bg-bg-color/80 transition-all outline outline-2 outline-offset-2 outline-transparent focus:outline focus:outline-offset-2 focus:outline-2 focus:outline-accent-color flex items-center justify-center px-4 h-10 ms-0 leading-tight text-font-color/60 bg-bg-color/40 rounded-lg">
					<span class="sr-only">First page</span>
					<svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
					</svg>
				</a>
			</li>
		<?php elseif ($page === '>'): ?>
		<li>
			<a href="/assets?<?= $myQuery ?>&page=<?= $pages ?>" class="hover:bg-bg-color/80 transition-all outline outline-2 outline-offset-2 outline-transparent focus:outline focus:outline-offset-2 focus:outline-2 focus:outline-accent-color flex items-center justify-center px-4 h-10 ms-0 leading-tight text-font-color/60 bg-bg-color/40 rounded-lg">
				<span class="sr-only">Last page</span>
				<svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
				</svg>
			</a>
		</li>
		<?php elseif ($page == $currentPage): ?>
		<li>
			<a class="hover:bg-accent-color/40 outline outline-2 outline-offset-2 outline-transparent focus:outline focus:outline-offset-2 focus:outline-2 focus:outline-accent-color transition-all flex items-center rounded-lg justify-center px-4 h-10 shadow-lg leading-tight text-secondary-font-color bg-accent-color/70" href="/assets?<?= $myQuery ?>&page=<?= $page ?>" aria-current="page"><?= $page ?></a>
		</li>
		<?php elseif ($page === '...'): ?>
		<?php else: ?>
		<li>
			<a class="hover:bg-bg-color/80 transition-all outline outline-2 outline-offset-2 outline-transparent focus:outline focus:outline-offset-2 focus:outline-2 focus:outline-accent-color flex items-center rounded-lg justify-center px-4 h-10 shadow-lg leading-tight text-font-color/60 bg-bg-color/40" href="/assets?<?= $myQuery ?>&page=<?= $page ?>"><?= $page ?></a>
		</li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</nav>
<?php endif; ?>
