<?php

use Entities\AssetFilters;
use Entities\Category;
use Entities\User;

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

$trendingCategories = array_slice($categories, 0, 4);
usort($trendingCategories, function ($a, $b) {
	return $b->asset_count <=> $a->asset_count;
});

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<? renderComponent('head'); ?>
	<title>assets</title>
</head>

<body>
	<header>
		<? renderComponent('navbar', ['categories' => $trendingCategories]); ?>
		<script src="/js/filters.js" defer></script>
	</header>
	<section class="pb-2">
		<div class="mb-8">
			<h1>Assets</h1>
			<?php if ($user): ?>
				<p class="text-font-color/70">By author: <span class="text-accent-color/80"><?= $user->name ?></span></p>
			<?php endif; ?>

			<?php if (isset($category)): ?>
				<p class="text-font-color/70">By category: <span class="text-accent-color/80"><?= $category->name ?></span></p>
				<p class="text-font-color/70"> <?= $category->description ?? '' ?></p>
			<?php endif; ?>
		</div>
	</section>
	<section class="p-2 rounded-xl shadow-lg bg-secondary-bg-color/50 mb-8">
		<?php renderComponent('assets/filters', ['categories' => $categories, 'filters' => $filters, 'prices' => $prices, 'pages' => $pages]) ?>
		<ul class="grid grid-cols-4 gap-4">
			<?php if (!$assets): ?>
				<li>No assets found</li>
			<?php endif; ?>
			<?php foreach ($assets as $asset): ?>
				<?php renderComponent('assets/asset-card', ['asset' => $asset]); ?>
			<?php endforeach; ?>
		</ul>
		<?php renderComponent('assets/pagination', ['pages' => $pages]) ?>
	</section>
	<?php renderComponent('footer', ['categories' => $trendingCategories]); ?>
</body>

</html>