<?php

use Entities\Asset;
use Entities\Category;

/**
 * @var Category[] $categories
 * @var string $errorMessage
 * @var array $previousData
 * @var Asset $asset
 * @var array $errors
 */
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php renderComponent('head'); ?>
		<title>create file</title>
	</head>
	<body>
		<header>
			<?php renderComponent('navbar', ['categories' => $categories]); ?>
		</header>
		<main>
			<section>
				<h1 class="text-center">create file for <?= $asset->name ?></h1>
				<a class="link mx-auto size-fit block" href="/profile/assets/<?= $asset->id ?>/files">Back to files</a>
				<?php renderComponent('assets/files-form', [
				'file' => null,
				'path' => "/profile/assets/{$asset->id}/files/create",
				'type' => 'create',
				'previousData' => $previousData ?? [],
				'errors' => $errors ?? [],
				'errorMessage' => $errorMessage ?? null,
				]); ?>
			</section>
		</main>
		<?php renderComponent('footer', ['categories' => $categories]); ?>
	</body>
</html>
