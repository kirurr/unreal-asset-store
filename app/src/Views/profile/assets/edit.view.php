<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Unreal Asset Store</title>
    </head>
    <body>
		<h1>edit asset <?= $asset->name ?></h1>
        <a href="/profile/assets/<?php echo $asset->id ?>/images/">images</a>
        <form action="/profile/assets/<?php echo $asset->id ?>" method="post">
            <input type="hidden" name="_method" value="put">
            <label for="name">name</label>
            <input type="text" name="name" value="<?php echo $asset->name ?>">
            <label for="info">info</label>
            <input type="text" name="info" value="<?php echo $asset->info ?>">
            <label for="description">description</label>
            <textarea name="description"><?php echo $asset->description ?></textarea>
            <label for="price">price</label>
            <input type="number" name="price" value="<?php echo $asset->price ?>">
            <label for="engine_version">engine_version</label>
            <input type="number" name="engine_version" value="<?php echo $asset->engine_version ?>">
            <select name="category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">save</button>
        </form>
		<div>
			<span>preview image</span>
			<img src="<?php echo $asset->preview_image ?>" alt="preview image">
		</div>

		<?php if (isset($errorMessage)) : ?>
			<p><?php echo $errorMessage ?></p>
		<?php endif; ?>
        <a href="/profile/">back</a>
        <form action="/profile/assets/<?php echo $asset->id ?>/" method="post">
            <input type="hidden" name="_method" value="delete">
            <button type="submit">delete</button>
        </form>
    </body>
