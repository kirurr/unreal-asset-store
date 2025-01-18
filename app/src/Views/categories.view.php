<?php

use Entities\Category;

/** @var Category[] $categories */

usort($categories, function ($a, $b) {
    return $b->asset_count <=> $a->asset_count;
});
$trendingCategories = array_slice($categories, 0, 4);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php renderComponent('head'); ?>
    <title>Categories</title>
</head>

<body>
    <header>
        <?php renderComponent('navbar', ['categories' => $trendingCategories]); ?>
    </header>
    <main class="mb-auto">
        <section>
            <div class="mx-auto max-w-screen-md p-2 shadow-lg rounded-xl bg-secondary-bg-color/50">
                <h1 class="text-center">Categories</h1>
                <div class="overflow-x-scroll lg:overflow-x-clip">
                    <table>
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>description</th>
                                <th>asset Count</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= $category->name ?></td>
                                    <td><?= $category->description ?></td>
                                    <td><?= $category->asset_count ?></td>
                                    <td>
                                        <a class="link" href="/assets?category_id=<?= $category->id ?>">view</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
    <?php renderComponent('footer', ['categories' => $trendingCategories]); ?>
</body>

</html>
