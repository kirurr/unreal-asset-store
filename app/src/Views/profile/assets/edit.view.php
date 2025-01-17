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

usort($categories, function ($a, $b) {
    return $b->asset_count <=> $a->asset_count;
});
$trendingCategories = array_slice($categories, 0, 4);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php renderComponent('head'); ?>
    <?php renderComponent('tinymce', ['selector' => '#description']) ?>
    <title>Unreal Asset Store</title>
</head>

<body>
    <header>
        <?php renderComponent('navbar', ['categories' => $trendingCategories]); ?>
    </header>
    <main>
        <section>
            <div class="flex flex-col lg:flex-row items-center mb-4 lg:mb-0">
                <h1 class="text-center lg:text-start">you are editing <?= $asset->name ?></h1>
                <div class="lg:ml-auto">
                    <a class="link" href="/profile/assets/<?php echo $asset->id ?>/images/">Edit images</a>
                    <a class="link" href="/profile/assets/<?php echo $asset->id ?>/files/">Edit files</a>
                </div>
            </div>
            <?php renderComponent(
                'assets/form',
                [
                    'categories' => $categories,
                    'previousData' => $previousData ?? [],
                    'errors' => $errors ?? [],
                    'asset' => $asset,
                    'action' => "/profile/assets/{$asset->id}",
                    'isEdit' => true,
                    'method' => 'put'
                ]
            ) ?>
            <div class="flex gap-4 justify-center">
                <a class="link" href="/profile/">back</a>
                <a class="link" href="/profile/assets/<?= $asset->id ?>">reset</a>
                <form action="/profile/assets/<?php echo $asset->id ?>/" method="post">
                    <input type="hidden" name="_method" value="delete">
                    <button class="link text-red-500/80" type="submit">delete</button>
                </form>
            </div>
        </section>
    </main>
    <?php renderComponent('footer', ['categories' => $trendingCategories]); ?>
</body>