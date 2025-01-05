<?php

use Entities\Asset;

/** @var array{ id: int, name: string, email: string } $user */
/** @var Asset[] $topAssets */
/** @var Asset[] $moreAssets */
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="/style.css">
		<script src="/js/colapsable.js" defer></script>
		<title>Unreal Asset Store</title>
	</head>
	<body>
		<header class="header">
			<? renderComponent('navbar', ['user' => $user]);?>
		</header>
		<main>
			<section class="section">
				<? renderComponent('main/top-assets', ['assets' => $topAssets]);?>
			</section>
			<section class="section">
				<? renderComponent('main/more-assets', ['assets' => $moreAssets]);?>
			</section>
		</main>
		<footer>

		</footer>
	</body>	
</html>
