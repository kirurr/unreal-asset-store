<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
</head>
<body>
    <form id="create-category-form" method="post" action="/admin/categories/create">
        <h2>Create Category</h2>
        <input type="text" name="name" placeholder="name" value="<?= $previousData['name'] ?? '' ?>">
        <input type="text" name="description" placeholder="description" value="<?= $previousData['description'] ?? '' ?>">
        <input hidden type="text" name="_method" value="POST">
        <button type="submit">create category</button>
		<p> <?= $errorMessage ?? '' ?></p>
    </form>
</body>
