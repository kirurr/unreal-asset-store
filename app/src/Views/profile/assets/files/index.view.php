<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>files</title>
</head>
	<body>
		<h1>files</h1>
		<a href="/profile/assets/<?= $asset_id ?>/files/create">create</a>
		<? if (count($files) === 0) : ?>
			<p>no files</p>
		<? else : ?>
			<? foreach ($files as $file): ?>
				<a href="/profile/assets/<?= $asset_id ?>/files/<?= $file->id ?>">
					file: <?= $file->name ?>
				</a>
			<? endforeach; ?>
		<? endif; ?>
	</body>
</html>
