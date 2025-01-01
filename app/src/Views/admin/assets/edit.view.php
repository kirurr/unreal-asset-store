<?php
use Entities\Asset;
use Entities\Category;

/**
 * @var Asset $asset 
 */
/**
 * @var Category[] $categories 
 */
/**
 * @var string|null $errorMessage 
 */
/**
 * @var array{ name: string, info: sting, description: string, price: string, engine_version: string, category_id: string } $errors 
 */
/**
 * @var array{ name: string, info: sting, description: string, price: string, engine_version: string, category_id: string } $previousData  
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
        <h1>edit asset</h1>
        <a href="/admin/assets/<?php echo $asset->id ?>/images/">images</a>
        <a href="/admin/assets/<?php echo $asset->id ?>/files/">files</a>
        <form action="/admin/assets/<?php echo $asset->id ?>" method="post">
            <input type="hidden" name="_method" value="put">
            <label for="name">name</label>
            <span><?php echo $errors['name'] ?? ''?></span>
            <input type="text" name="name" value="<?php echo $previousData['name'] ?? $asset->name ?>">

            <label for="info">info</label>
            <span><?php echo $errors['info'] ?? ''?></span>
            <input type="text" name="info" value="<?php echo $previousData['info'] ?? $asset->info ?>">

            <label for="description">description</label>
            <textarea name="description"><?php echo $previousData['description'] ?? $asset->description ?></textarea>
            <span><?php echo $errors['description'] ?? ''?></span>

            <label for="price">price</label>
            <input type="number" name="price" value="<?php echo $previousData['price'] ?? $asset->price ?>">
            <span><?php echo $errors['price'] ?? ''?></span>

            <label for="engine_version">engine_version</label>
            <input type="text" name="engine_version" value="<?php echo $previousData['engine_version'] ?? $asset->engine_version ?>">
            <span><?php echo $errors['engine_version'] ?? ''?></span>

            <select name="category_id">
                <?php foreach ($categories as $category): ?>
                <option
                    <?php echo (isset($previousData['category_id']) ? $previousData['category_id'] == $category->id : $asset->category_id == $category->id) ? "selected" : ""?>
                value="<?php echo $category->id ?>">
                    <?php echo $category->name ?>
                </option>
                <?php endforeach; ?>
            </select>
            <span><?php echo $errors['engine_version'] ?? ''?></span>
            <button type="submit">save</button>
        </form>
        <div>
            <span>preview image</span>
            <img src="<?php echo $asset->preview_image ?>" alt="preview image">
        </div>

        <?php if (isset($errorMessage)) : ?>
            <p><?php echo $errorMessage ?></p>
        <?php endif; ?>
        <a href="/admin/assets">back</a>
        <form action="/admin/assets/<?php echo $asset->id ?>/" method="post">
            <input type="hidden" name="_method" value="delete">
            <button type="submit">delete</button>
        </form>
    </body>
