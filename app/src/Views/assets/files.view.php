<?php

use Entities\Asset;
use Entities\Category;
use Entities\File;
use Entities\User;

/**
 * @var Asset $asset
 * @var Category $category
 * @var Category[] $trendingCategories
 * @var User $user
 * @var File[] $files
 */
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php renderComponent('head'); ?>
	<title>files for asset</title>
</head>

<body>
	<header>
		<?php renderComponent('navbar', ['categories' => $trendingCategories]); ?>
	</header>
	<main>
		<section>
			<div class="text-center">
				<h1>files for <?= $asset->name ?></h1>
				<a class="link" href="/assets/<?= $asset->id ?>">back to asset</a>
			</div>
			<ul class="mt-8 flex flex-col gap-4 mx-auto lg:w-2/3">
				<?php foreach ($files as $file): ?>
					<li class="rounded-xl shadow-lg bg-secondary-bg-color/70 p-4 flex flex-col lg:flex-row lg:divide-x-2 lg:divide-font-color/20">
						<div class="lg:w-2/3">
							<h2><?= $file->name ?></h2>
							<p class=" text-font-color/70"><?= $file->description ?></p>
						</div>
						<div class="lg:w-1/3 lg:px-2 mt-4 lg:mt-0 border-t-2 border-font-color/20 py-4 lg-py-0">
							<p class=" text-font-color/70">version: <?= $file->version ?></p>
							<p class=" text-font-color/70">uploaded: <?= $file->GetFormatedCreatedAt() ?></p>
							<p class=" text-font-color/70">size: <?= $file->getFormatedSize() ?></p>
							<a class="mt-8 link" href="/assets/<?= $asset->id ?>/files/<?= $file->id ?>" download> download </a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	</main>
	<?php renderComponent('footer', ['categories' => $trendingCategories]); ?>
</body>
</html>
