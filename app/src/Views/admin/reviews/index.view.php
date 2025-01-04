<?php
use Entities\Review;

/** @var Review[] $reviews */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reviews</title>
</head>
<body>
	<h1>reviews</h1>
	<table>
		<thead>
			<tr>
				<th>id</th>
				<th>asset_id</th>
				<th>user_id</th>
				<th>content</th>
				<th>created_at</th>
				<th>action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($reviews as $review): ?>
				<tr>
					<td><?= $review->id ?></td>
					<td><?= $review->asset_id ?></td>
					<td><?= $review->user->name ?></td>
					<td><?= $review->review ?></td>
					<td><?= $review->created_at ?></td>
					<td>
						<a href="/admin/reviews/<?= $review->id ?>">edit</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>
