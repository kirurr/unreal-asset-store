<?php

use Entities\Asset;
use Entities\Category;

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
            <h1>you are creating new asset</h1>
            <?php renderComponent(
                'assets/form',
                [
                    'categories' => $categories,
                    'previousData' => $previousData ?? [],
                    'errors' => $errors ?? [],
                    'asset' => null,
                    'action' => '/admin/assets/create',
                    'isEdit' => false,
                    'method' => 'post'
                ]
            ) ?>
            <div class="flex gap-4 justify-center">
                <a class="link" href="/admin/assets/">back</a>
            </div>
        </section>
    </main>
</body>