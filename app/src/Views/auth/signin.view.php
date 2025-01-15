<?php

use Entities\Category;

/**
 * @var array{email: string, password: string} $previousData
 * @var string $errorMessage
 * @var array<string, string> $errors
 * @var Category[] $categories
 */
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php renderComponent('head'); ?>
	<title>Sign In</title>
	<script src="/js/auth.js" defer></script>
</head>

<body>
	<header>
		<?php renderComponent('navbar', ['categories' => $categories]); ?>
	</header>
	<main class="flex flex-col items-center justify-center">
		<form id="sign-in-form" method="post" action="/signin" class="text-center w-[20rem] bg-secondary-bg-color/50 p-4 rounded-xl shadow-lg">
			<h1>sign in</h1>

			<label for="emali" class="label mt-4">Email</label>
			<input 
				class="input <?= isset($errors['email']) ? 'error' : '' ?>"
				type="email"
				required
				name="email" placeholder="example@email.com" value="<?= $previousData['email'] ?? '' ?>">
			<span class="mt-2"><?= $errors['email'] ?? '' ?></span>

			<label for="password" class="label mt-4">Password</label>
			<input
				class="input <?= isset($errors['password']) ? 'error' : '' ?>"
				required
				type="text"
				name="password" placeholder="***************" value="<?= $previousData['password'] ?? '' ?>">
			<span class="mt-2"><?= $errors['password'] ?? '' ?></span>

			<input hidden type="text" name="_method" value="POST">
			<button class="button accent mx-auto mt-4" type="submit">Sign in</button>
			<p id="errorMessage" class="mt-4"> <?= $errorMessage ?? '' ?></p>
		<a href="/signup" class="link mt-4">Sign up</a>
		</form>
	</main>
	<?php renderComponent('footer', ['categories' => $categories]); ?>
</body>

</html>
