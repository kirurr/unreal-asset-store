<?php

use Entities\Category;

/**
 * @var Category[] $categories 
 */
/**
 * @var array $previousData 
 */
/**
 * @var string|null $errorMessage 
 */
/**
 * @var array $errors 
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
    <title>assets</title>
</head>

<body>
    <header>
        <?php renderComponent('navbar', ['categories' => $trendingCategories]); ?>
    </header>
    <main>
        <section>
            <h1>Create Asset</h1>
            <?php renderComponent(
                'assets/form',
                [
                    'categories' => $categories,
                    'previousData' => $previousData ?? [],
                    'errors' => $errors ?? [],
                    'asset' => null,
                    'action' => '/profile/assets/create',
                    'isEdit' => false,
                    'method' => 'post'
                ]
            ) ?>
        </section>
    </main>
    <?php renderComponent('footer', ['categories' => $trendingCategories]); ?>
</body>

</html>