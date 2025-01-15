<?php

use Entities\Review;
use Entities\Category;

/** @var Category[] $trendingCategories */
/** @var Review $review */
/** @var array{ title: string, review: string, posititive: string, negative: string, is_positive: string } $errors */
/** @var array{ title: string, review: string, posititive: string, negative: string, is_positive: string } $previousData */
/** @var string $errorMessage */
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php renderComponent('head'); ?>
	<title>edit review <?=$review->title ?></title>
</head>

<body>
	<header>
		<?php renderComponent('navbar', ['categories' => $trendingCategories]); ?>
	</header>
	<main>
		<section class="text-center">
			<h1 class="mb-4">edit review</h1>
			<?php renderComponent(
				'reviews/form',
				[
					'review' => $review,
					'errors' => $errors ?? null,
					'previousData' => $previousData ?? null,
					'errorMessage' => $errorMessage ?? null,
					'path' => '/profile/reviews/'
				]
			); ?>
		</section>
	</main>
	<?php renderComponent('footer', ['categories' => $trendingCategories]); ?>
</body>

</html>