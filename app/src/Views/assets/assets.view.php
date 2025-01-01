<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>assets</title>
</head>
	<body>
		<h1>Assets</h1>
		<?php renderComponent('assets/filters', ['categories' => $categories, 'filters' => $filters, 'prices' => $prices]) ?>
		<ul>
			<?php foreach ($assets as $asset) : ?>
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
