<?php

use Entities\Category;

use Entities\Asset;

/**
 * @var Asset $asset
 * @var string $errorMessage
 * @var Category[] $categories
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>purchase asset</title>
		<?php renderComponent("head"); ?>	
</head>
<body class="flex flex-col h-screen justify-between">
		<header>
			<?php renderComponent("navbar", ["categories" => $categories]); ?>
		</header>
		<main class="text-center flex flex-col justify-center items-center">
			<h1>purchase asset</h1>
			<form action="/assets/<?= $asset->id ?>/purchase/" method="post">
				<button class="button accent mt-8" type="submit">purchase</button>
			</form>
		</main>
		<p><?= $errorMessage ?? '' ?></p>
		<?php renderComponent("footer", ["categories" => $categories]); ?>
</body>
</html>
