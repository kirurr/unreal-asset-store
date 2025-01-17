<?php

/**
 * @var array{ name: string, description: string } $previousData 
 */
/**
 * @var string $errorMessage 
 */
/**
 * @var array<string, string> $errors 
 */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php renderComponent('head'); ?>
    <title>Create Category</title>
</head>

<body class="justify-normal">
    <header>
        <?php renderComponent('admin/navbar'); ?>
    </header>
    <main>
        <section>
            <form class="p-2 rounded-xl shadow-lg bg-secondary-bg-color/50 max-w-screen-sm mx-auto flex flex-col items-center gap-4" id="create-category-form" method="post" action="/admin/categories/create">
                <input hidden type="text" name="_method" value="POST">
                <h1>create category</h1>
                <div>
                    <label class="label" for="name">name</label>
                    <input class="input" required type="text" name="name" placeholder="name" value="<?= $previousData['name'] ?? '' ?>">
                    <span><?= $errors['name'] ?? '' ?></span>
                </div>

                <div>
                    <label for="description" class="label">description</label>
                    <input class="input" required type="text" name="description" placeholder="description" value="<?php echo $previousData['description'] ?? '' ?>">
                    <span><?= $errors['description'] ?? '' ?></span>

                </div>
                <button class="button accent" type="submit">create category</button>
                <p> <?php echo $errorMessage ?? '' ?></p>
                <a href="/admin/categories" class="link">back</a>
            </form>
        </section>
    </main>
</body>