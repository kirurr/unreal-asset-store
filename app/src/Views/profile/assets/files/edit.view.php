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
            <input type="text" name="name" value="<?php echo $file->name ?>">
            <label for="version">Version</label>
            <input type="text" name="version" value="<?php echo $file->version ?>">
            <label for="description">Description</label>
            <textarea name="description"><?php echo $file->description ?></textarea>
            <label for="file">File</label>
            <input type="file" name="file" id="file">
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
