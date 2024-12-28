<?php
use Entities\Category;
/**
 * @var Category $category
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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Unreal Asset Store</title>
    </head>
    <body>
        <h1>edit category</h1>
        <form action="/admin/categories/<?php echo $category->id ?>" method="post">
            <input type="hidden" name="_method" value="put">
            <label for="name">name</label>
            <span><?php echo $errors['name'] ?? '' ?></span>
            <input type="text" name="name" value="<?php echo $category->name ?>">
            <label for="description">description</label>
            <textarea name="description"><?php echo $category->description ?></textarea>
            <span><?php echo $errors['description'] ?? '' ?></span>
            <button type="submit">save</button>
        </form>
        <p> <?php echo $errorMessage ?? '' ?></p>
        <a href="/admin/categories">back</a>
        <a href="/admin/categories/<?php echo $category->id ?>">reset</a>
        <form action="/admin/categories/<?php echo $category->id ?>/" method="post">
            <input type="hidden" name="_method" value="delete">
            <button type="submit">delete</button>
        </form>
    </body>
