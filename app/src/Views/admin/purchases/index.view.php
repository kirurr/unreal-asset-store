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
	<?php renderComponent('head'); ?>
	<title>purchases</title>
</head>

<body class="justify-normal">
	<header>
		<?php renderComponent('admin/navbar'); ?>
	</header>
	<main>
		<section>
			<div class="p-2 rounded-xl shadow-lg bg-secondary-bg-color/50 max-w-screen-md mx-auto">
				<h1 class="text-center lg:text-start">purchases</h1>
				<div class="overflow-x-scroll">
					<table>
						<thead>
							<tr>
								<th>id</th>
								<th>asset</th>
								<th>user</th>
								<th>created</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($purchases as $purchase): ?>
								<tr>
									<td><?= $purchase->id ?></td>
									<td><a href="/assets/<?= $purchase->asset_id ?>/" class="lvink">view asset</a></td>
									<td><a href="/assets?user_id=<?= $purchase->user_id ?>">view assets by user</a></td>
									<td><?= $purchase->getFormatedPurchaseDate() ?></td>
									<td>
										<form action="/admin/purchases/<?= $purchase->id ?>/" method="post">
											<input type="hidden" name="_method" value="DELETE">
											<button class="link text-red-500/80 hover:text-red-500/50" type="submit">delete</button>
										</form>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</main>
</body>

</html>