<?php

use Entities\Category;

/** @var Category[] $categories */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php renderComponent('head'); ?>
    <title>categories</title>
</head>

<body class="justify-normal">
    <header>
        <?= renderComponent('admin/navbar') ?>
    </header>
    <main>
        <section>
            <div class="p-2 rounded-xl shadow-lg bg-secondary-bg-color/50">
                <div class="flex flex-col lg:flex-row items-center">
                    <h1>categories</h1>
                    <a class="button accent lg:ml-auto" href="/admin/categories/create">create category</a>
                </div>
                <div class="overflow-x-scroll">
                    <table class="table-auto w-full divide-y-2 divide-font-color/20">
                        <thead>
                            <tr>
                                <th class="p-4 text-start">
                                    name
                                </th>
                                <th class="p-4 text-start">
                                    description
                                </th>
                                <th class="p-4 text-start">
                                    assets
                                </th>
                                <th class="p-4">

                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-font-color/5">
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td class="p-4"><?= $category->name ?></td>
                                    <td class="p-4"><?= $category->description ?></td>
                                    <td class="p-4"><?= $category->asset_count ?></td>
                                    <td class="p-4">
                                        <a class="link" href="/admin/categories/<?= $category->id ?>">Edit</a>
                                        <a class="link" href="/assets/?category=<?= $category->id ?>">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

</body>

</html>