<?php

use Entities\Category;

/**
 * @var Category[] $categories
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
</head>
<body>
    <h1>Categories</h1>
    <?php echo renderComponent('admin/navbar') ?>
    <a href="/admin/categories/create">Create Category</a>

    <?php if (count($categories) > 0) : ?>
        <?php foreach ($categories as $category): ?>
        <a href="/admin/categories/<?php echo $category->id ?>"><?php echo $category->name ?></a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No categories</p>
    <?php endif; ?>
</body>
</html>
