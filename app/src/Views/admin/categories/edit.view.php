<?php

/**
 * @var Category $category
 */
/**
/**
 * @var array{ name: string, description: string } $previousData 
 */
/**
 * @var string $errorMessage 
 */
/**
 * @var array<string, string> $errors 
 */

$previousData = [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php renderComponent('head'); ?>
    <title>Update Category</title>
</head>

<body class="justify-normal">
    <header>
        <?php renderComponent('admin/navbar'); ?>
    </header>
    <main>
        <section>
            <div class="p-2 rounded-xl shadow-lg bg-secondary-bg-color/50 max-w-screen-sm mx-auto">

                <form class="flex flex-col items-center gap-4" id="create-category-form" method="post" action="/admin/categories/<?= $category->id ?>">
                    <input hidden type="text" name="_method" value="PUT">
                    <h1>category <?= $category->name ?></h1>
                    <div>
                        <label class="label" for="name">name</label>
                        <input class="input" required type="text" name="name" placeholder="name" value="<?= retrieveData($previousData, $category, 'name'); ?>">
                        <span><?= $errors['name'] ?? '' ?></span>
                    </div>

                    <div>
                        <label for="description" class="label">description</label>
                        <input class="input" required type="text" name="description" placeholder="description" value="<?= retrieveData($previousData, $category, 'name'); ?>">
                        <span><?= $errors['description'] ?? '' ?></span>

                    </div>
                    <button class="button accent" type="submit">submit</button>
                    <p> <?php echo $errorMessage ?? '' ?></p>
                </form>
                <div class="flex gap-4 mt-4 items-center justify-center">
                    <a href="/admin/categories" class="link">back</a>
                    <a href="/admin/categories/<?= $category->id ?>" class="link">reset</a>
                    <form action="/admin/categories/<?php echo $category->id ?>/" method="post">
                        <input type="hidden" name="_method" value="delete">
                        <button class="link mx-auto block text-red-500/80 hover:text-red-500/50" type="submit">delete</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>