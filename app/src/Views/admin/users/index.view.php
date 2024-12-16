<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Users</title>
</head>
	<body>
		<h1>Users</h1>
		<?php renderComponent('admin/navbar'); ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Actions</th>
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
							<a href="/admin/users/<?= $user->id ?>">Edit</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>
</html>
