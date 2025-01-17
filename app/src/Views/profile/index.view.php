<?php

use Entities\Review;
use Entities\User;
use Entities\Category;
use Entities\Asset;

/**
 * @var User $user
 * @var Category[] $trendingCategories
 * @var Asset[] $assets
 * @var array{1: Asset, 2: Review} $reviews
 * @var array<string, string> $links
 */


$links = [
	"created" => "Your assets",
	"purchased" => "Your purchased assets",
];

$currentLink = $_GET['assets'] ?? 'created';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php renderComponent('head'); ?>
	<title>Profile</title>
</head>

<body>
	<header>
		<?php renderComponent('navbar', ['categories' => $trendingCategories]); ?>
	</header>
	<main>
		<section class="flex">
			<h1 class="mb-4">Profile</h1>
			<div class="ml-auto">
				<div class="bg-secondary-bg-color/50 p-2 rounded-xl shadow-lg">
					<ul class="flex flex-col gap-4 list-none mb-4">
						<li class="flex gap-4">
							<p>Name</p>
							<p><?= $user->name ?></p>
						</li>
						<li class="flex gap-4">
							<p>Email</p>
							<p><?= $user->email ?></p>
						</li>
						<li>
							<a href="/signout" class="link text-red-500/80">Sign out</a>
						</li>
					</ul>
				</div>
			</div>
		</section>
		<section id="assets">
			<h2>Your Assets</h2>
			<div>
				<div class="bg-secondary-bg-color/50 p-2 rounded-xl shadow-lg">
					<ul class="flex gap-4 list-none mb-4">
						<?php foreach ($links as $key => $value): ?>
							<li class="more-assets-list <?= $key === $currentLink ? 'active' : '' ?>">
								<a class="p-2 block" href="/profile?assets=<?= $key ?>#assets">
									<?= $value ?>
								</a>
							</li>
						<?php endforeach; ?>
						<li class="ml-auto">
							<a class="p-2 block button accent" href="/profile/assets/create">
								Create asset
							</a>
						</li>
					</ul>
					<div>
						<table class="table-auto w-full divide-y-2 divide-font-color/20">
							<thead>
								<tr>
									<th class="p-4 text-start">

									</th>
									<th class="p-4 text-start">
										name
									</th>
									<th class="p-4 text-start">
										info
									</th>
									<th class="p-4 text-start">
										downloads
									</th>
									<th class="p-4 text-start">
										created
									</th>
									<?php if ($currentLink === 'purchased'): ?>
										<th class="p-4 text-start">
											user
										</th>
									<?php endif; ?>
									<th class="p-4 text-start">
										category
									</th>
									<th class="p-4 text-start">
										price
									</th>
									<th class="p-4">

									</th>
								</tr>
							</thead>
							<tbody class="divide-y-2 divide-font-color/5">
								<?php foreach ($assets as $asset): ?>
									<tr>
										<td>
											<div>
												<!-- TODO: add image -->
												<!-- <img src="<?= $asset->preview_image ?>" alt="<?= $asset->name ?>" class="w-16 h-16 rounded-full"> -->
											</div>
										</td>
										<td class="p-4"><?= $asset->name ?></td>
										<td class="p-4"><?= $asset->info ?></td>
										<td class="p-4">
											<?= $asset->purchase_count ?>
										</td>
										<td class="p-4">
											<?php
											$date = new DateTime();
											$date->setTimestamp($asset->created_at);
											?>
											<?= $date->format('d M Y') ?>
										</td>
										<?php if ($currentLink === 'purchased'): ?>
											<td class="p-4">
												<a class="link" href="/assets?=user_id=<?= $asset->user->id ?>"><?= $asset->user->name ?></a>
											</td>
										<?php endif; ?>
										<td class="p-4">
											<a class="link" href="/assets?category_id=<?= $asset->category->id ?>"><?= $asset->category->name ?></a>
										</td>
										<?php if ($asset->price > 0): ?>
											<td class="p-4"><?= $asset->price ?> USD</td>
										<?php else: ?>
											<td class="p-4 text-green-500/70">Free asset</td>
										<?php endif; ?>
										<td class="p-4">
											<?php if ($asset->user->id === $user->id): ?>
												<a class="link" href="/profile/assets/<?= $asset->id ?>">Edit</a>
											<?php endif; ?>
											<a class="link" href="/assets/<?= $asset->id ?>">View</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>
		<section id="reviews">
			<h2>Your reviews</h2>
			<div>
				<div class="bg-secondary-bg-color/50 p-2 rounded-xl shadow-lg">
					<div>
						<?php if (count($reviews) > 0): ?>
							<table class="table-auto w-full divide-y-2 divide-font-color/20">
								<thead>
									<tr>
										<th class="p-4 text-start">
											asset
										</th>
										<th class="p-4 text-start">
											title
										</th>
										<th class="p-4 text-start">
											review
										</th>
										<th class="p-4 text-start">
											positive
										</th>
										<th class="p-4 text-start">
											negative
										</th>
										<th class="p-4 text-start">
											is positive?
										</th>
										<th class="p-4 text-start">
											created
										</th>
										<th class="p-4">

										</th>
									</tr>
								</thead>
								<tbody class="divide-y-2 divide-font-color/5">
									<?php foreach ($reviews as $item): ?>
										<?php
										[$asset, $review] = $item;
										?>
										<tr>
											<td class="p-4"><?= $asset->name ?></td>
											<td class="p-4"><?= $review->title ?></td>
											<td class="p-4"><?= $review->review ?></td>
											<td class="p-4"><?= $review->positive ?></td>
											<td class="p-4"><?= $review->negative ?></td>
											<?php if ($review->is_positive): ?>
												<td class="p-4 text-green-500/70">positive</td>
											<?php else: ?>
												<td class="p-4 text-red-500/70">negative</td>
											<?php endif; ?>
											<td class="p-4">
												<?php
												$reviewDate = new DateTime();
												$reviewDate->setTimestamp($review->created_at);
												?>
												<?= $reviewDate->format('d M Y') ?>
											</td>
											<td class="p-4 flex gap-2">
												<a class="link" href="/profile/reviews/<?= $review->id ?>">Edit</a>
												<form action="/profile/reviews/<?= $review->id ?>/" method="post">
													<input type="hidden" name="_method" value="DELETE">
													<button type="submit" class="link text-red-500/80"">Delete</button>
												</form>
												<a class="link" href="/assets/<?= $asset->id ?>">View</a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p class="text-center">You haven't reviewed any assets yet.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
	</main>
	<?php renderComponent('footer', ['categories' => $trendingCategories]); ?>
</body>

</html>