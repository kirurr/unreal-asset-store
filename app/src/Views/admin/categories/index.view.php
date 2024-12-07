<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
</head>
<body>
    <h1>Categories</h1>
    <a href="/admin/categories/create">Create Category</a>

	<?php if (count($categories) > 0): ?>
    <?php foreach ($categories as $category): ?>
        <a href="/admin/categories/<?= $category['id'] ?>"><?= $category['name'] ?></a>
    <?php endforeach; ?>
	<?php else: ?>
		<p>No categories</p>
	<?php endif; ?>
</body>
</html>
