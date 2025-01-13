<?php

use Entities\Asset;
use Entities\Category;
use Entities\User;
use Entities\File;

/**
 * @var Asset $asset
 * @var Category $category
 * @var User $user
 * @var File[] $files
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>files for asset</title>
</head>
<body>
		<header>
			<?php renderComponent('navbar'); ?>
		</header>
		<h1>files for asset</h1>
		<a href="/assets/<?= $asset->id ?>">back to asset</a>
		<?php foreach ($files as $file): ?>
			<h2><?= $file->name ?></h2>
		<a href="/assets/<?= $asset->id ?>/files/<?= $file->id ?>" download> download </a>
		<?php endforeach; ?>
</body>
</html>
