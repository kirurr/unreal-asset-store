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
				<li class="relative flex flex-col rounded-xl overflow-hidden shadow-lg">	
					<a href="/assets/<?= $asset->id ?>/" tabindex="-1" class="h-[55%] hover:scale-105 transition-all">
						<img src="<?= $asset->preview_image ?>" class="size-full object-cover" alt="<?= $asset->name ?>">
					</a>
					<div class="bg-bg-color/40 h-[45%] p-2 flex flex-col gap-4 relative z-10">
						<div>
							<h3 class="hover:text-font-color/50 transition-colors w-fit"><a href="/assets/<?= $asset->id ?>/"><?= $asset->name ?></a></h3>
							<a class="no-underline link" href="assets?category_id=<?= $asset->category->id ?>"><?= $asset->category->name ?></a>
							<p class="text-font-color/70 text-sm">
								Author
								<a class="link no-underline" href="/assets?user_id=<?= $asset->user->id ?>"><?= $asset->user->name ?></a>
							</p>

							<?php
                            $date = new DateTime();
                            $date->setTimestamp($asset->created_at);
                            ?>

							<p class="text-font-color/70 text-sm">Uploaded <?= $date->format('d M Y') ?></p>
							<?php if ($asset->price > 0): ?>
								<p class="text-font-color/70 text-sm mt-2"><?= $asset->price ?> USD</p>
							<?php else: ?>
								<p class="text-green-300/70 text-sm mt-2">Free asset</p>
							<?php endif; ?>
						</div>
						<div>
							<p class="text-font-color/70 text-md text-ellipsis break-words line-clamp-3"><?= $asset->info ?></p>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php renderComponent('assets/pagination', ['pages' => $pages]) ?>
		</section>
		<?php renderComponent('footer', ['categories' => $trendingCategories]); ?>
	</body>
</html>
