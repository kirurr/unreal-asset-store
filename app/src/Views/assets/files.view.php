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
	<body class="flex flex-col h-screen justify-between">
		<header>
			<?php renderComponent('navbar', ['categories' => $trendingCategories]); ?>
		</header>
		<main>
			<section>
				<div class="text-center">
					<h1>files for <?= $asset->name ?></h1>
					<a class="link" href="/assets/<?= $asset->id ?>">back to asset</a>
				</div>
				<ul class="mt-8 flex flex-col gap-4">
					<?php foreach ($files as $file): ?>
					<li class="rounded-xl shadow-lg bg-secondary-bg-color/70 p-4">
						<h2><?= $file->name ?></h2>
						<a href="/assets/<?= $asset->id ?>/files/<?= $file->id ?>" download> download </a>
					</li>
					<?php endforeach; ?>
				</ul>
			</section>
		</main>
		<?php renderComponent('footer', ['categories' => $trendingCategories]); ?>
	</body>
</html>
