<?php
/**
 * @var array{email: string, password: string} $previousData
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
    <title>Sign In</title>
</head>
	<body>
		<form id="sign-in-form" method="post" action="/signin">
			<h2>sign in</h2>
			<input type="text" name="email" placeholder="email"value="<?= $previousData['email'] ?? '' ?>">
			<span><?= $errors['email'] ?? '' ?></span>
			<input type="text" name="password" placeholder="password" value="<?= $previousData['password'] ?? '' ?>">
			<span><?= $errors['password'] ?? '' ?></span>
			<input hidden type="text" name="_method" value="POST">
			<button type="submit">sign in</button>
			<p> <?= $errorMessage ?? '' ?></p>
		</form>
	</body>
</html>
