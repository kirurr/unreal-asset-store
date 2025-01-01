<?php

use Entities\File;

/**
 * @var string $errorMessage
 * @var array $previousData
 * @var int $asset_id
 * @var array $errors
 * @var File $file
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit file</title>
</head>
    <body>
        <h1>edit file</h1>
        <form action="/profile/assets/<?php echo $asset_id ?>/files/<?php echo $file->id ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="put">
            <input type="hidden" name="path" value="<?php echo $file->path ?>">

            <label for="name">Name</label>
            <input type="text" name="name" value="<?php echo $previousData['name'] ?? $file->name ?>">
            <span><?php echo $errors['name'] ?? '' ?></span>

            <label for="version">Version</label>
            <input type="text" name="version" value="<?php echo $previousData['version'] ?? $file->version ?>">
            <span><?php echo $errors['version'] ?? '' ?></span>

            <label for="description">Description</label>
            <textarea name="description"><?php echo $previousData['description'] ?? $file->description ?></textarea>
            <span><?php echo $errors['description'] ?? '' ?></span>

            <label for="file">File</label>
            <input type="file" name="file" id="file">
            <span><?php echo $errors['file'] ?? '' ?></span>
            <button type="submit">Submit</button>
            <p><?php echo $errorMessage ?? '' ?></p>
        </form>
        <form action="/profile/assets/<?php echo $asset_id ?>/files/<?php echo $file->id ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="delete">
            <button type="submit">Delete</button>
        </form>
        <p><a href="/profile/assets/<?php echo $asset_id ?>/files">Back</a></p>
    </body>
</html>
