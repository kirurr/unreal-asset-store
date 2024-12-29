<?php
/**
 * @var array{email: string, password: string, name: string} $previousData
 * @var string $errorMessage
 * @var array<string, string> $errors
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
	<body>
		<form id="sign-up-form" method="post" action="/signup">
			<h2>sign up</h2>
			<input type="text" name="name" placeholder="name"value="<?= $previousData['name'] ?? '' ?>">
			<span><?= $errors['name'] ?? '' ?></span>
			<input type="text" name="email" placeholder="email"value="<?= $previousData['email'] ?? '' ?>">
			<span><?= $errors['email'] ?? '' ?></span>
			<input type="text" name="password" placeholder="password" value="<?= $previousData['password'] ?? '' ?>">
			<span><?= $errors['password'] ?? '' ?></span>
			<input hidden type="text" name="_method" value="POST">
			<button type="submit">sign up</button>
			<p> <?= $errorMessage ?? '' ?></p>
		</form>
	</body>
</html>
