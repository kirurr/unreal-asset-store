<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>assets</title>
</head>
    <body>
    <h1>Assets</h1>
    <a href="/profile/assets/create">Create Asset</a>

	<?php if (count($assets) > 0): ?>
    <?php foreach ($assets as $asset): ?>
        <a href="/profile/assets/<?= $asset->id ?>"><?= $asset->name ?></a>
    <?php endforeach; ?>
	<?php else: ?>
		<p>No assets</p>
	<?php endif; ?>
    </body>
</html>    
