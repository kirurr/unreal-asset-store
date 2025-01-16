<?php

use Entities\Asset;
use Entities\Category;
use Entities\File;

/**
 * @var Category[] $categories
 * @var string $errorMessage
 * @var array $previousData
 * @var Asset $asset
 * @var array $errors
 * @var File $file
 */
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php renderComponent('head'); ?>
		<title>edit file</title>
	</head>
	<body>
		<header>
			<?php renderComponent('navbar', ['categories' => $categories]); ?>
		</header>
		<main>
			<section>
				<h1 class="text-center">edit file for <?= $asset->name ?></h1>
				<a class="link mx-auto size-fit block" href="/profile/assets/<?= $asset->id ?>/files">Back to files</a>
				<?php renderComponent('assets/files-form', [
				'file' => $file,
				'path' => "/profile/assets/{$asset->id}/files/{$file->id}",
				'type' => 'edit',
				'previousData' => $previousData ?? [],
				'errors' => $errors ?? [],
				'errorMessage' => $errorMessage ?? null,
				]); ?>
			</section>
		</main>
		<?php renderComponent('footer', ['categories' => $categories]); ?>
	</body>
</html>
