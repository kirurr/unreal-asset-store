<?php
/**
 * @var array{ name: string, description: string } $previousData 
 */
/**
 * @var string $errorMessage 
 */
/**
 * @var array<string, string> $errors 
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
</head>
<body>
    <form id="create-category-form" method="post" action="/admin/categories/create">
        <input hidden type="text" name="_method" value="POST">
        <h2>Create Category</h2>
        <input type="text" name="name" placeholder="name" value="<?php echo $previousData['name'] ?? '' ?>">
        <span><?= $errors['name'] ?? '' ?></span>
        <input type="text" name="description" placeholder="description" value="<?php echo $previousData['description'] ?? '' ?>">
        <span><?= $errors['description'] ?? '' ?></span>
        <button type="submit">create category</button>
        <p> <?php echo $errorMessage ?? '' ?></p>
    </form>
</body>
