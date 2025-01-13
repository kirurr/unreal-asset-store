<?php
/**
 * @var Image[] $images
 */
/**
 * @var Asset $asset
 */
/**
 * @var string|null $errorMessage
 */
/**
 * @var string $asset_id
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Images for asset</title>
</head>
    <body>
        <h1>Images for asset</h1>
        <p><?php echo $errorMessage ?? '' ?></p>
        <?php foreach ($images as $image): ?>
        <div>
            <img src="<?php echo $image->path ?>" alt="image ">
            <form action="/admin/assets/<?php echo $asset_id ?>/images/" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="path" value="<?php echo $image->path ?>">
                <input type="hidden" name="image_order" value="<?php echo $image->image_order ?>">
                <input type="hidden" name="id" value="<?php echo $image->id ?>">
                <input type="file" name="images">
                <button type="submit">update</button>
            </form>

            <?php if ($asset->preview_image !== $image->path) : ?>
            <form action="/admin/assets/<?php echo $asset_id ?>/images/" method="post">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="id" value="<?php echo $image->id ?>">
                <button type="submit">delete</button>
            </form>
            <?php endif; ?>
            <?php if ($asset->preview_image === $image->path) : ?>
                <span>this is preview image</span>
            <?php else: ?>
            <form action="/admin/assets/<?php echo $asset_id ?>/images/" method="post">
                <input type="hidden" name="_method" value="patch">
                <input type="hidden" name="id" value="<?php echo $image->id ?>">
                <button type="submit">make preview</button>
            </form>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <form action="/admin/assets/<?php echo $asset_id ?>/images/" method="post" enctype="multipart/form-data">
            <h2>add new images</h2>
            <input type="hidden" name="_method" value="post">
            <input type="hidden" name="last_order" value="<?php $images[array_key_last($images)]->image_order?>">
            <input type="file" name="images[]" multiple>
            <button type="submit">add images</button>
        </form>
    </body>
</html>
