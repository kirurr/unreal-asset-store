<?php

use Entities\Category;
use Entities\Purchase;

/**
 * @var Category $category
 * @var Purchase[] $purchases
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>purchases</title>
</head>
<body>
	<h1>purchases</h1>
	<table>
		<thead>
			<tr>
				<th>id</th>
				<th>asset_id</th>
				<th>user_id</th>
				<th>created_at</th>
				<th>action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($purchases as $purchase): ?>
				<tr>
					<td><?= $purchase->id ?></td>
					<td><?= $purchase->asset_id ?></td>
					<td><?= $purchase->user_id ?></td>
					<td><?= $purchase->purchase_date ?></td>
					<td>
						<form action="/admin/purchases/<?= $purchase->id ?>/" method="post">
							<input type="hidden" name="_method" value="DELETE">
							<button type="submit">delete</button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>
