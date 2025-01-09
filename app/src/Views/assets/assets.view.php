<?php

use Entities\User;
use Entities\AssetFilters;
use Entities\Category;

/** @var Asset[] $assets */
/** @var Category[] $categories */
/** @var array{ min: int, max: int } $prices */
/** @var AssetFilters $filters */
/** @var int $pages */
/** @var User $user */

if ($filters->category_id) {
	$categoryIndex = array_search($filters->category_id, array_column($categories, 'id'));
	$category = $categories[$categoryIndex];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<? renderComponent('head'); ?>
	<title>assets</title>
</head>
	<body>
		<h1>Assets</h1>
		<?php if($user): ?>
			<p>by author <?= $user->name ?></p>
		<?php endif; ?>

		<?php if(isset($category)): ?>
			<p>by category <?= $category->name ?></p>
		<?php endif; ?>
			
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
