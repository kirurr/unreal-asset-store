<?php

use Entities\Asset;
use Entities\File;

/**
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
	<body class="justify-normal">
		<header>
			<?php renderComponent('admin/navbar'); ?>
		</header>
		<main>
			<section>
				<h1 class="text-center">edit file for <?= $asset->name ?></h1>
				<a class="link mx-auto size-fit block" href="/admin/assets/<?= $asset->id ?>/files">Back to files</a>
				<?php renderComponent('assets/files-form', [
				'file' => $file,
				'path' => "/admin/assets/{$asset->id}/files/{$file->id}",
				'type' => 'edit',
				'previousData' => $previousData ?? [],
				'errors' => $errors ?? [],
				'errorMessage' => $errorMessage ?? null,
				]); ?>
			</section>
		</main>
	</body>
</html>
