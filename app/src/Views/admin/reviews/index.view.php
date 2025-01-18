<?php

use Entities\Review;

/** @var Review[] $reviews */
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php renderComponent('head'); ?>
	<title>reviews</title>
</head>

<body class="justify-normal">
	<header>
		<?php renderComponent('admin/navbar'); ?>
	</header>
	<main>
		<section>
			<div class="p-2 rounded-xl shadow-lg bg-secondary-bg-color/50 mx-auto">
				<h1 class="overflow-x-scroll lg:overflow-x-clip">reviews</h1>
				<div class="bg-secondary-bg-color/50 p-2 rounded-xl shadow-lg">
					<div class="overflow-x-scroll lg:overflow-x-clip">
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
									<?php foreach ($reviews as $review): ?>
										<tr>
											<td class="p-4"><a class="link whitespace-nowrap" href="/assets/<?= $review->asset_id ?>">View asset</a></td>
											<td class="p-4"><?= $review->title ?></td>
											<td class="p-4 whitespace-normal"><?= $review->review ?></td>
											<td class="p-4 whitespace-normal"><?= $review->positive ?></td>
											<td class="p-4 whitespace-normal"><?= $review->negative ?></td>
											<?php if ($review->is_positive): ?>
												<td class="p-4 text-green-500/70">positive</td>
											<?php else: ?>
												<td class="p-4 text-red-500/70">negative</td>
											<?php endif; ?>
											<td class="p-4"><?= $review->getFormatedCreatedAt() ?></td>
											<td class="p-4 flex flex-col gap-2">
												<a class="link" href="/admin/reviews/<?= $review->id ?>">Edit</a>
												<form action="/admin/reviews/<?= $review->id ?>/" method="post">
													<input type="hidden" name="_method" value="DELETE">
													<button type="submit" class="link text-red-500/80"">Delete</button>
												</form>
												<a class="link" href="/assets/<?= $review->asset_id ?>/#reviews">View</a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p class="text-center">no reviews yet</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
	</main>
</body>

</html>
