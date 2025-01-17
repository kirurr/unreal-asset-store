<?php

use Entities\Review;

/** @var Review $review */
/** @var array{ title: string, review: string, posititive: string, negative: string, is_positive: string } $errors */
/** @var array{ title: string, review: string, posititive: string, negative: string, is_positive: string } $previousData */
/** @var string $errorMessage */
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php renderComponent('head'); ?>
	<title>edit review</title>
</head>

<body class="justify-normal">
	<header>
		<?php renderComponent('admin/navbar'); ?>
	</header>
	<main>
		<section>
			<h1 class="text-center">edit review</h1>
			<?php renderComponent(
				'reviews/form',
				[
					'review' => $review,
					'errors' => $errors ?? [],
					'previousData' => $previousData ?? [],
					'errorMessage' => $errorMessage ?? '',
					'path' => '/admin/reviews/'
				]
			); ?>
			<a href="/admin/reviews/" class="link mx-auto block w-fit mt-4">back to reviews</a>
		</section>
	</main>
</body>

</html>