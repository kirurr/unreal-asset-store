<?php
use Entities\Review;

/**
 * @var Review $review
 * @var  array{ review: string, is_positive: bool, positive: string, negative: string } $previousData
 * @var string $errorMessage
 * @var array{ review: string, is_positive: string, positive: string, negative: string } $errors
 */
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
	<form action="/admin/reviews/<?= $review->id ?>/" method="post">
		<input type="hidden" name="_method" value="PUT">
		<label for="review">review</label>
		<textarea name="review" rows="4" cols="50"><?= $previousData['review'] ?? $review->review ?></textarea>
		<span><?= $errors['review'] ?? '' ?></span>

		<label for="is_positive">is positive?</label>
		<input type="checkbox" name="is_positive" value="1"
			<?php if (isset($previousData['is_positive'])): ?>
				<?= $previousData['is_positive'] ? 'checked' : '' ?>
			<?php else: ?>
				<?= $review->is_positive ? 'checked' : '' ?>
			<?php endif; ?>
		<span><?= $errors['is_positive'] ?? '' ?></span>

		<label for="positive">positive</label>
		<textarea name="positive" rows="4" cols="50"><?= $previousData['positive'] ?? $review->positive ?></textarea>
		<span><?= $errors['positive'] ?? '' ?></span>

		<label for="negative">negative</label>
		<textarea name="negative" rows="4" cols="50"><?= $previousData['negative'] ?? $review->negative ?></textarea>
			<span><?= $errors['negative'] ?? '' ?></span>

		<input type="submit" value="update review">
		<?= $errorMessage ?? '' ?>
	</form>
</body>
</html>
