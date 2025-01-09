<?php

use Entities\Asset;
use Entities\Category;

/**
 * @var array{ id: int, name: string, email: string } $user
 */

/**
 * @var Asset[] $topAssets
 */

/**
 * @var Asset[] $moreAssets
 */

/** 
* @var Category[] $trendingCategories
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
			<? renderComponent('navbar', ['categories' => $trendingCategories]); ?>
		</header>
		<main>
			<section>
				<? renderComponent('main/top-assets', ['assets' => $topAssets]);?>
			</section>
			<section class="w-full max-w-full bg-secondary-bg-color py-8">
				<div class="max-w-screen-xl mx-auto flex justify-evenly items-center"> 
					<h2>Join our growing community</h2>
					<div class="flex flex-col gap-4 items-center">
						<p class="text-xl">Already have an account? <a class="link" href="/login">Login</a></p>
						<a href="/signup" class="button accent">Register</a>
					</div>
				</div>
			</section>
			<section id="more-assets">
				<? renderComponent('main/more-assets', ['assets' => $moreAssets]);?>
			</section>
		</main>
		<? renderComponent('footer', ['categories' => $trendingCategories]); ?>
	</body>	
</html>
