<?php

use Entities\Asset;

/**
 * @var array{ id: int, name: string, email: string } $user
 */

/**
 * @var Asset[] $topAssets
 */

/**
 * @var Asset[] $moreAssets
 */
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<? renderComponent('head'); ?>
		<title>Unreal Asset Store</title>
	</head>
	<body>
		<header class="header">
			<? renderComponent('navbar', ['user' => $user]);?>
		</header>
		<main>
			<section>
				<? renderComponent('main/top-assets', ['assets' => $topAssets]);?>
			</section>
			<section class="w-full max-w-full bg-secondary-bg-color">
				<div class="max-w-screen-xl mx-auto"> 
					<h2>register</h2>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis eum, earum nihil perferendis consectetur eligendi sapiente ea recusandae est dignissimos!</p>
					<button>Register</button>
				</div>
			</section>
			<section id="more-assets">
				<? renderComponent('main/more-assets', ['assets' => $moreAssets]);?>
			</section>
		</main>
		<footer>

		</footer>
	</body>	
</html>
