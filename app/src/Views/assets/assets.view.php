<?php
/** @var Asset[] $assets */
/** @var Category[] $categories */
/** @var array{ min: int, max: int } $prices */
/** @var AssetFilters $filters */
/** @var int $pages */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<? renderComponent('head'); ?>
	<title>assets</title>
</head>
	<body>
		<h1>Assets</h1>
		<?php renderComponent('assets/filters', ['categories' => $categories, 'filters' => $filters, 'prices' => $prices, 'pages' => $pages]) ?>
		<?php renderComponent('assets/pagination', ['pages' => $pages]) ?>
		<ul>
			<?php if (!$assets): ?>
				<li>No assets found</li>
			<?php endif; ?>
			<?php foreach ($assets as $asset): ?>
				<li>
					<h2><?= $asset->name ?></h2>
					<p><?= $asset->info ?></p>
					<p><?= $asset->description ?></p>
					<p><?= $asset->price ?></p>
					<p><?= $asset->engine_version ?></p>
					<p><?= $asset->category->name ?></p>
					<img src="<?= $asset->preview_image ?>" alt="<?= $asset->name ?>">
					<a href="/assets/<?= $asset->id ?>/edit">Edit</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</body>
</html>
