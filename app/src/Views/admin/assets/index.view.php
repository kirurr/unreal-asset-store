<?php

use Entities\Asset;

/** @var Asset[] $assets */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php renderComponent('head'); ?>
    <title>assets</title>
</head>

<body class="justify-normal">
    <header>
        <?= renderComponent('admin/navbar') ?>
    </header>
    <main>
        <section>
            <div class="p-2 rounded-xl shadow-lg bg-secondary-bg-color/50">
                <div class="flex items-center">
                    <h1>Assets</h1>
                    <a class="button accent ml-auto" href="/admin/assets/create">Create Asset</a>
                </div>
                <div class="overflow-x-scroll lg:overflow-x-clip">
                    <table class="table-auto w-full divide-y-2 divide-font-color/20">
                        <thead>
                            <tr>
                                <th class="p-4 text-start">
                                    name
                                </th>
                                <th class="p-4 text-start">
                                    info
                                </th>
                                <th class="p-4 text-start">
                                    downloads
                                </th>
                                <th class="p-4 text-start">
                                    created
                                </th>
                                <th class="p-4 text-start">
                                    user
                                </th>
                                <th class="p-4 text-start">
                                    category
                                </th>
                                <th class="p-4 text-start">
                                    price
                                </th>
                                <th class="p-4">

                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-font-color/5">
                            <?php foreach ($assets as $asset): ?>
                                <tr>
                                    <td class="p-4"><?= $asset->name ?></td>
                                    <td class="p-4"><?= $asset->info ?></td>
                                    <td class="p-4">
                                        <?= $asset->purchase_count ?>
                                    </td>
                                    <td class="p-4">
                                        <?php
                                        $date = new DateTime();
                                        $date->setTimestamp($asset->created_at);
                                        ?>
                                        <?= $date->format('d M Y') ?>
                                    </td>
                                    <td class="p-4">
                                        <a class="link" href="/assets?=user_id=<?= $asset->user->id ?>"><?= $asset->user->name ?></a>
                                    </td>
                                    <td class="p-4">
                                        <a class="link" href="/assets?category_id=<?= $asset->category->id ?>"><?= $asset->category->name ?></a>
                                    </td>
                                    <?php if ($asset->price > 0): ?>
                                        <td class="p-4"><?= $asset->price ?> USD</td>
                                    <?php else: ?>
                                        <td class="p-4 text-green-500/70">Free asset</td>
                                    <?php endif; ?>
                                    <td class="p-4">
                                        <a class="link" href="/admin/assets/<?= $asset->id ?>">Edit</a>
                                        <a class="link" href="/assets/<?= $asset->id ?>">View</a>
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
