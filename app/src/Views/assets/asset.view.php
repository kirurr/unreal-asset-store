<?php

use Services\Session\SessionService;

use Entities\Asset;
use Entities\Category;
use Entities\User;

/**
 * @var Asset $asset
 * @var Category $category
 * @var User $user
 * @var bool $isUserPurchasedAsset
 * @var Review[] $reviews
 * @var array{ previousData: array{ review: string, is_positive: bool, positive: string, negative: string }, errors: array, errorMessage: string } $review
 */

$session = SessionService::getInstance();
$user = $session->getUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>asset <?= $asset->name ?></title>
	<? renderComponent('head'); ?>
</head>
<body>
	<h1>asset <?= $asset->name ?></h1>
	<p>category: <?= $category->name ?></p>
	<p>description: <?= $asset->description ?></p>
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

		<div>
			<h2>reviews</h2>
			<?php if ($user): ?>
			<form action="/assets/<?= $asset->id ?>/review" method="post">
				<input type="hidden" name="_method" value="POST">
				<label for="review">review</label>
				<textarea name="review" rows="4" cols="50"><?= $review['previousData']['review'] ?? '' ?></textarea>
				<span><?= $review['errors']['review'] ?? '' ?></span>

				<label for="is_positive">is positive?</label>
				<input type="checkbox" name="is_positive" value="1" <?= isset($review['previousData']['is_positive']) ? $review['previousData']['is_positive'] ? 'checked' : '' : '' ?>>

				<label for="positive">positive</label>
				<textarea name="positive" rows="4" cols="50"><?= $review['previousData']['positive'] ?? '' ?></textarea>

				<label for="negative">negative</label>
				<textarea name="negative" rows="4" cols="50"><?= $review['previousData']['negative'] ?? '' ?></textarea>

				<input type="submit" value="add review">
				<span><?= $review['errorMessage'] ?? '' ?></span>
			</form>
			<?php endif; ?>
			<?php foreach ($reviews as $review): ?>
				<p><?= $review->review ?></p>
				<p>by <?= $review->user->name ?></p>
			<?php endforeach; ?>
		</div>

</body>
</html>
