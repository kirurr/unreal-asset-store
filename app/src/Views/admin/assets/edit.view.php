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
        <title>Unreal Asset Store</title>
        <?php renderComponent('head'); ?>
        <?php renderComponent('tinymce', ['selector' => '#description']) ?>
    </head>
    <body class="justify-normal">
<header>
    <?php renderComponent('admin/navbar'); ?>
</header>
<main>
    <section>
        <div class="flex items-center">
                <h1>you are editing <?= $asset->name ?></h1>
                <div class="ml-auto">
                    <a class="link" href="/admin/assets/<?= $asset->id ?>/images/">Edit images</a>
                    <a class="link" href="/admin/assets/<?= $asset->id ?>/files/">Edit files</a>
                </div>
            </div>
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
<div class="flex gap-4 justify-center">
                <a class="link" href="/admin/">back</a>
                <a class="link" href="/admin/assets/<?= $asset->id ?>">reset</a>
                <form action="/admin/assets/<?= $asset->id ?>/" method="post">
                    <input type="hidden" name="_method" value="delete">
                    <button class="link text-red-500/80" type="submit">delete</button>
                </form>
            </div>
    </section>
</main>
    </body>
