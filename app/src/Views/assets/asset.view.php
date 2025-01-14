<?php

use Entities\Asset;
use Entities\Category;
use Entities\Review;
use Entities\User;
use Services\Session\SessionService;

/**
 * @var Asset $asset
 * @var Category $category
 * @var Category[] $trendingCategories
 * @var User $user
 * @var bool $isUserPurchasedAsset
 * @var Review[] $reviews
 * @var array{ previousData: array{ review: string, is_positive: bool, positive: string, negative: string }, errors: array, errorMessage: string } $newReview
 */
$session = SessionService::getInstance();
$user = $session->getUser();

$assetDate = new DateTime();
$assetDate->setTimestamp($asset->created_at);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>asset <?= $asset->name ?></title>
		<? renderComponent('head'); ?>
		<script src="/js/splide/splide.min.js"></script>
		<script src="/js/asset-carousel.js" defer></script>
	</head>
	<body>
		<header>
			<?php renderComponent('navbar', ['categories' => $trendingCategories]) ?>
		</header>
		<main class="max-w-screen-xl mx-auto asset-grid">
			<aside class="col-start-2 row-span-1 w-[20rem] flex flex-col gap-2 my-16 top-0 sticky">
				<div class="p-4 rounded-xl shadow-lg bg-bg-color/40">
					<h1><?= $asset->name ?></h1>
					<p class="text-font-color/70">Category: <a class="link" href="/asset?category_id=<?= $asset->category->id ?>"><?= $asset->category->name ?></a></p>
					<p class="text-font-color/70">Author: <a class="link" href="/asset?user_id=<?= $asset->user->id ?>"><?= $asset->user->name ?></a></p>
					<p class="text-font-color/70">Created: <?= $assetDate->format('d M Y') ?></p>

					<?php if (isset($asset->engine_version) && intval($asset->engine_version) !== 0): ?>
					<p class="text-font-color/70">Engine version: <?= $asset->engine_version ?></p>
					<?php endif; ?>
				</div>

				<div class="p-4 rounded-xl shadow-lg bg-bg-color/40">
					<p class="text-font-color/70"><?= $asset->info ?></p>
				</div>
				<div class="p-4 rounded-xl shadow-lg bg-bg-color/40">
					<?php if ($asset->price > 0): ?>
					<p>Price: <?= $asset->price ?> USD</p>
					<?php else: ?>
					<p class="text-green-300/70">Free asset</p>
					<?php endif; ?>

					<div class="mt-4">
						<?php if($asset->price === 0): ?>
						<a class="button mx-auto" href="/assets/<?= $asset->id ?>/files">Download</a>

						<?php elseif ($isUserPurchasedAsset): ?>
						<p class="mb-2 text-font-color/70">You have purchased this asset</p>
						<a class="button mx-auto" href="/assets/<?= $asset->id ?>/files">Download</a>

						<?php elseif($asset->price === 0): ?>
						<a class="button mx-auto" href="/assets/<?= $asset->id ?>/files">Download</a>

						<?php elseif (isset($user) && $asset->price > 0): ?>
						<a class="button accent mx-auto" href="/assets/<?= $asset->id ?>/purchase">Purchase</a>

						<?php elseif (!isset($user)): ?>
						<p class="mb-2 text-font-color/70">You need to be logged in to purchase this asset</p>
						<a class="link mx-auto block w-fit" href="/signin">Sign in</a>
						<?php endif; ?>
					</div>
				</div>
				<div class="p-4 rounded-xl shadow-lg bg-bg-color/40">
					<p class="text-font-color/70">Downloaded <?= $asset->purchase_count ?> times</p>
				</div>
			</aside>
			<section class="col-start-1 row-start-1">
				<div class="flex gap-4 bg-secondary-bg-color/70 rounded-xl p-4">
					<div class="flex flex-col">
						<div id="main-carousel" class="max-h-[30rem] splide size-full">
							<div class="splide__track rounded-xl overflow-hidden size-full">
								<ul class="splide__list relative size-full flex">
									<?php foreach ($asset->images as $image): ?>
									<li class="splide__slide min-w-full size-full rounded-xl overflow-hidden">
										<img class="size-full object-cover" src="<?= $image->path ?>" alt="<?= $asset->name ?>">
									</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
						<?php if (count($asset->images) > 1): ?>
						<div id="thumbnails-carousel" class="splide size-full">
							<div class="splide__track h-fit py-2 size-full overflow-x-hidden">
								<ul class="splide__list size-full flex">
									<?php foreach ($asset->images as $image): ?>
									<li class="splide__slide border-2 border-solid border-transparent h-[6rem] thumbnail rounded-xl overflow-hidden">
										<img class="size-full object-cover" src="<?= $image->path ?>" alt="<?= $asset->name ?>">
									</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
			<section class="col-start-1 row-start-2">
				<?= $asset->description ?>
			</section>
			<section class="col-start-1 row-start-3 w-full">
				<h2>Reviews</h2>
				<ul>
					<?php foreach ($reviews as $review): ?>
					<?php
						$reviewDate = new DateTime();
						$reviewDate->setTimestamp($asset->created_at);
					?>
					<li class="my-4 shadow-lg bg-secondary-bg-color/50 p-4 rounded-xl">
						<h3><?= $review->title ?></h3>
						<p class="text-font-color/70 text-sm">by <?= $review->user->name ?></p>
						<p class="text-font-color/70 text-sm mb-2"><?= $reviewDate->format('d M Y') ?></p>
						<p><?= $review->review ?></p>

						<?php if ($review->positive): ?>
						<p class="text-font-color/70 text-sm mt-2">positive:</p>
						<p><?= $review->positive ?></p>
						<?php endif; ?>

						<?php if ($review->negative): ?>
						<p class="text-font-color/70 text-sm mt-2">negative:</p>
						<p><?= $review->negative ?></p>
						<?php endif; ?>

						<?php if ($review->is_positive): ?>
						<p class="text-green-300/70 text-sm mt-2">positive</p>
						<?php else: ?>
						<p class="text-red-300/70 text-sm mt-2">negative</p>
						<?php endif; ?>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php if ($user): ?>
				<form class="w-2/3 mx-auto p-4 rounded-xl shadow-lg bg-secondary-bg-color/50 mt-8" action="/assets/<?= $asset->id ?>/newReview" method="post">
					<h3>add new review</h3>
					<input type="hidden" name="_method" value="POST">

					<label for="title" class="label">title</label>
					<input required class="input" placeholder="Title" type="text" name="title" id="title" value="<?= $newReview['previousData']['title'] ?? '' ?>">

					<label class="label mt-4" for="review">review</label>
					<textarea class="textarea" required placeholder="Your review about the asset" id="review" name="review" rows="4" cols="50"><?= $newReview['previousData']['newReview'] ?? '' ?></textarea>
					<span><?= $newReview['errors']['newReview'] ?? '' ?></span>

					<label class="label mt-4" for="positive">positive</label>
					<textarea name="positive" class="textarea" placeholder="Something positive about the asset" rows="4" cols="50"><?= $newReview['previousData']['positive'] ?? '' ?></textarea>

					<label class="label mt-4" for="negative">negative</label>
					<textarea name="negative" rows="4" cols="50" class="textarea" placeholder="Something negative about the asset"><?= $newReview['previousData']['negative'] ?? '' ?></textarea>
					<div class="mt-4">
						<div>
							<label for="is_positive">positive</label>
							<input required type="radio" name="is_positive" value="1"
								<?php if (isset($newReview['previousData']['is_positive'])) {
								echo $newReview['previousData']['is_positive'] == 1 ? 'checked' : '';
								} else {
								echo 'checked';
								} ?>>

						</div>
						<div>
							<label for="negative">negative</label>
							<input required id="negative" class="radio" type="radio" name="is_positive" value="0"
								<?php if (isset($newReview['previousData']['is_positive'])) {
								echo $newReview['previousData']['is_positive'] == 0 ? 'checked' : '';
								} ?>>
						</div>
					</div>

					<button type="submit" class="button accent mx-auto">Add new review</button>
					<span><?= $newReview['errorMessage'] ?? '' ?></span>
				</form>
				<?php else: ?>
				<div class="text-center mt-8">
					<p class="text-font-color/70">You need to be logged in to add a review</p>
					<a class="link mx-auto block w-fit" href="/signin">Sign in</a>
				</div>
				<?php endif; ?>
			</section>
		</main>
		<?php renderComponent('footer', ['categories' => $trendingCategories]) ?>
	</body>
</html>
