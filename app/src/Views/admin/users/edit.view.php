<?php

use Entities\Asset;
use Entities\User;

/**
 * @var User $user 
 */
/**
 * @var string $errorMessage 
 */
/**
 * @var Asset[] $assets 
 */
/**
 * @var array $previousData 
 */
/**
 * @var array $errors 
 */
$previousData =  $previousData ?? [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php renderComponent('head'); ?>
    <title>Edit User</title>
</head>

<body class="justify-normal">
    <header>
        <?php renderComponent('admin/navbar'); ?>
    </header>
    <main>
        <section>
            <div class="p-2 mx-auto max-w-screen-sm shadow-lg rounded-xl bg-secondary-bg-color/50">
                <h1 class="text-center">edit user <?= $user->name ?></h1>
                <form action="/admin/users/<?php echo $user->id ?>" method="post" class="flex flex-col gap-4 items-center">
                    <input type="hidden" name="_method" value="put">
                    <div>
                        <label class="label" for="name">name</label>
                        <input type="text" class="input" name="name" value="<?= retrieveData($previousData, $user, 'name'); ?>">
                        <span><?php echo $errors['name'] ?? '' ?></span>
                    </div>

                    <div>
                        <label class="label" for="email">email</label>
                        <input required class="input" type="text" name="email" value="<?= retrieveData($previousData, $user, 'email'); ?>">
                        <span><?php echo $errors['email'] ?? '' ?></span>
                    </div>
                    <div>
                        <label class="label" for="password">new password</label>
                        <input type="text" class="input" name="password">
                        <span><?php echo $errors['password'] ?? '' ?></span>
                    </div>

                    <div>
                        <label class="label" for="role">role</label>
                        <select class="select" name="role">
                            <option value="admin" <?php echo $user->role === 'admin' ? 'selected' : '' ?>>admin</option>
                            <option value="user" <?php echo $user->role === 'user' ? 'selected' : '' ?>>user</option>
                        </select>
                        <span><?php echo $errors['role'] ?? '' ?></span>
                    </div>
                    <button class="button accent" type="submit">submit</button>
                </form>
                <?php echo $errorMessage ?? '' ?>
                <div class="flex gap-4 justify-center mt-4">
                    <a class="link" href="/admin/users">back</a>
                    <form action="/admin/users/<?php echo $user->id ?>/" method="post">
                        <input type="hidden" name="_method" value="delete">
                        <button class="link text-red-500/80 hover:text-red-500/50" type="submit">delete</button>
                    </form>
                </div>

            </div>
        </section>
    </main>
</body>

</html>