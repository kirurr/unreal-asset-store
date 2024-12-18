<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
    <body>
        <?php echo $user->name ?>
		<div>
			<h2>Assets</h2>
			<a href="/profile/assets/create">Create Asset</a>
			<ul>
			<?php foreach ($assets as $asset): ?>
				<li>
					<a href="/assets/<?php echo $asset->id ?>"><?php echo $asset->name ?></a>
					<a href="/profile/assets/<?php echo $asset->id ?>/">Edit</a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
    </body>
</html>
