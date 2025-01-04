<?php

use Entities\Review;
use Entities\User;

/**
 * @var User $user
 * @var Asset[] $assets
 * @var Asset[] $purchased_assets
 * @var Review[] $reviews
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
    <body>
        <?php echo $user->name ?>
		<div>
			<h2>Your Assets</h2>
			<a href="/profile/assets/create">Create Asset</a>
			<ul>
			<?php foreach ($assets as $asset): ?>
				<li>
					<a href="/assets/<?php echo $asset->id ?>"><?php echo $asset->name ?></a>
					<a href="/profile/assets/<?php echo $asset->id ?>/">Edit</a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h2>Your Purchased Assets</h2>
			<ul>
			<?php foreach ($purchased_assets as $asset): ?>
				<li>
					<a href="/assets/<?php echo $asset->id ?>"><?php echo $asset->name ?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>


		<div>
			<h2>Your Reviews</h2>
			<p>to edit your reviews, contact us</p>
			<ul>
			<?php foreach ($reviews as $review): ?>
				<li>
					<a href="/assets/<?= $review->asset_id ?>">show asset</a>
					<p><?= $review->review ?></p>
					<p>by <?= $review->user->name ?></p>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>

    </body>
</html>
