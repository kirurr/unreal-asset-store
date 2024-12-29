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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
    <body>
        <h1>Edit User</h1>
        <form action="/admin/users/<?php echo $user->id ?>" method="post">
            <input type="hidden" name="_method" value="put">
            <label for="name">name</label>
            <input type="text" name="name" value="<?php echo $previousData['name'] ?? $user->name ?>">
            <span><?php echo $errors['name'] ?? '' ?></span>
            <label for="email">email</label>
            <input type="text" name="email" value="<?php echo $previousData['email'] ?? $user->email ?>">
            <span><?php echo $errors['email'] ?? '' ?></span>
            <label for="password">new password</label>
            <input type="text" name="password">
            <span><?php echo $errors['password'] ?? '' ?></span>
            <label for="role">role</label>
            <select name="role">
                <option value="admin" <?php echo $user->role === 'admin' ? 'selected' : '' ?>>admin</option>
                <option value="user" <?php echo $user->role === 'user' ? 'selected' : '' ?>>user</option>
            </select>
            <span><?php echo $errors['role'] ?? '' ?></span>
            <button type="submit">save</button>
        </form>
        <?php echo $errorMessage ?? '' ?>
        <a href="/admin/users">back</a>
        <form action="/admin/users/<?php echo $user->id ?>/" method="post">
            <input type="hidden" name="_method" value="delete">
            <button type="submit">delete</button>
        </form>
        <h2>Assets</h2>
        <div>
            <?php foreach ($assets as $asset): ?>
            <img src="<?php echo $asset->preview_image ?>" alt="<?php echo $asset->name ?>">
            <a href="/admin/assets/<?php echo $asset->id ?>"><?php echo $asset->name ?></a>
            <?php endforeach; ?>
        </div>
    </body>
</html>
