<?php
/** @var int $pages */
$myQuery = '';
foreach ($_GET as $key => $value) {
	if ($key !== 'page') {
		$myQuery .= '&' . $key . '=' . $value;
	}
}
?>

<div>
	<h2>Pagination</h2>
	<?php if ($pages > 1): ?>
	<ul>
		<?php for ($i = 1; $i <= $pages; $i++): ?>
		<li>
			<a href="/assets?<?= $myQuery ?>&page=<?= $i ?>"><?= $i ?></a>
		</li>
		<?php endfor; ?>
	</ul>
	<?php endif; ?>
</div>
