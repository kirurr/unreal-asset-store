<?php

/**
 * @var array{email: string, password: string, name: string} $previousData
 * @var string $errorMessage
 * @var array<string, string> $errors
 * @var Category[] $categories
 */
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php renderComponent('head'); ?>
	<title>Sign Up</title>
	<script src="/js/auth.js" defer></script>
</head>

<body>
	<header>
		<?php renderComponent('navbar', ['categories' => $categories]); ?>
	</header>
	<main class="flex flex-col items-center justify-center">

		<form class="text-center w-[20rem] lg:bg-secondary-bg-color/50 p-4 rounded-xl shadow-lg" id="sign-up-form" method="post" action="/signup">
			<h1>Sign up</h1>

			<label for="name" class="label mt-4">Name</label>
			<input
				class="input <?= isset($errors['name']) ? 'error' : '' ?>"
				required
				type="text" name="name" placeholder="name" value="<?= $previousData['name'] ?? '' ?>">
			<span class="mt-2"><?= $errors['name'] ?? '' ?></span>

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
			<button class="button accent mx-auto mt-4" type="submit">Sign up</button>
			<p class="mt-4"> <?= $errorMessage ?? '' ?></p>
			<a href="/signin" class="link mt-4">Sign in</a>
		</form>
	</main>
	<?php renderComponent('footer', ['categories' => $categories]); ?>
</body>

</html>
