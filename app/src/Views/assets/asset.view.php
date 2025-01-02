<?php

use Entities\Asset;
use Entities\Category;
use Entities\User;

/**
 * @var Asset $asset
 * @var Category $category
 * @var User $user
 * @var bool $isUserPurchasedAsset
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>asset <?= $asset->name ?></title>
</head>
<body>
	<h1>asset <?= $asset->name ?></h1>
	<p>category: <?= $category->name ?></p>
	<p>price <?= $asset->price ?></p>


		<div>
	<?php if ($isUserPurchasedAsset): ?>
		<a href="/assets/<?= $asset->id ?>/files">files</a>
	<?php elseif (isset($user) && $asset->price > 0): ?>
		<a href="/assets/<?= $asset->id ?>/purchase">buy</a>
	<?php elseif (!isset($user)): ?>
		<p>you need to be logged in to buy asset</p>
		<a href="/auth/login">login</a>
		<a href="/auth/register">register</a>
	<?php elseif ($asset->price === 0): ?>
		<a href="/assets/<?= $asset->id ?>/files">files</a>
	<?php endif; ?>
		</div>
	<img src="<?= $asset->preview_image ?>" alt="preview image">
</body>
</html>
