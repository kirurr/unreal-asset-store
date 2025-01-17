<?php
use Entities\Asset;
/**
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
	<body class="justify-normal">
		<header>
			<?php renderComponent('admin/navbar'); ?>
		</header>
		<main>
			<section>
				<h1 class="text-center">create file for <?= $asset->name ?></h1>
				<a class="link mx-auto size-fit block" href="/admin/assets/<?= $asset->id ?>/files">Back to files</a>
				<?php renderComponent('assets/files-form', [
				'file' => null,
				'path' => "/admin/assets/{$asset->id}/files/create",
				'type' => 'create',
				'previousData' => $previousData ?? [],
				'errors' => $errors ?? [],
				'errorMessage' => $errorMessage ?? null,
				]); ?>
			</section>
		</main>
	</body>
</html>
