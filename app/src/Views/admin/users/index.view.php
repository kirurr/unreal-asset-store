<!DOCTYPE html>
<html lang="en">

<head>
	<?php renderComponent('head'); ?>
	<title>Users</title>
</head>

<body class="justify-normal">
	<header>
		<?php renderComponent('admin/navbar'); ?>
	</header>
	<main>
		<section>
			<div class="mx-auto max-w-screen-md p-2 bg-secondary-bg-color/50 rounded-lg shadow-md">
				<h1 class="text-center">Users</h1>
				<div class="overflow-x-scroll">
					<table>
						<thead>
							<tr>
								<th>id</th>
								<th>name</th>
								<th>email</th>
								<th>role</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($users as $user): ?>
								<tr>
									<td><?= $user->id ?></td>
									<td><?= $user->name ?></td>
									<td><?= $user->email ?></td>
									<td><?= $user->role ?></td>
									<td>
										<a class="link" href="/admin/users/<?= $user->id ?>">Edit</a>
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