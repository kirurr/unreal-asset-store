<?php
use Entities\Asset;
use Entities\Category;

/** @var Asset $asset */
/** @var Category[] $categories */
/** @var string|null $errorMessage */
/** @var array{ name: string, info: sting, description: string, price: string, engine_version: string, category_id: string } $errors */
/** @var array{ name: string, info: sting, description: string, price: string, engine_version: string, category_id: string } $previousData */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Unreal Asset Store</title>
		<?php renderComponent('tinymce', ['selector' => '#description']) ?>
    </head>
    <body>
        <h1>edit asset</h1>
        <a href="/admin/assets/<?php echo $asset->id ?>/images/">images</a>
        <a href="/admin/assets/<?php echo $asset->id ?>/files/">files</a>
		<?php renderComponent('assets/form',
            [
                'categories' => $categories,
                'previousData' => $previousData ?? [],
                'errors' => $errors ?? [],
                'asset' => $asset,
                'action' => "/admin/assets/{$asset->id}",
                'isEdit' => true,
                'method' => 'put'
            ]) ?>
        <div>
            <span>preview image</span>
            <img src="<?php echo $asset->preview_image ?>" alt="preview image">
        </div>

        <a href="/admin/assets">back</a>
        <form action="/admin/assets/<?php echo $asset->id ?>/" method="post">
            <input type="hidden" name="_method" value="delete">
            <button type="submit">delete</button>
        </form>
    </body>
