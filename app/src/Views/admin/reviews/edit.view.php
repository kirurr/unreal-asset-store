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
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>edit review</title>
</head>

<body>
	<h1>edit review</h1>
	<?php renderComponent(
		'reviews/form',
		[
			'review' => $review,
			'errors' => $errors,
			'previousData' => $previousData,
			'errorMessage' => $errorMessage,
			'path' => '/admin/reviews/'
		]
	); ?>
</body>

</html>