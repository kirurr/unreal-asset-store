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
		<script src="/js/splide/splide.min.js"></script>
		<script src="/js/main-carousel.js" defer></script>
		<title>Unreal Asset Store</title>
	</head>
	<body>
		<header>
			<? renderComponent('navbar', ['categories' => $trendingCategories]); ?>
		</header>
		<main>
			<section>
				<? renderComponent('main/top-assets', ['assets' => $topAssets]);?>
			</section>
			<section class="w-full max-w-full bg-secondary-bg-color py-8">
				<div class="max-w-screen-xl mx-auto flex lg:flex-rom flex-col justify-evenly items-center"> 
					<h2 class="lg:text-start text-center">Join our growing community</h2>
					<div class="flex flex-col gap-4 items-center mt-2 lg:mt-0">
						<a href="/signup" class="button lg:text-[1.7rem] lg:p-4 accent">Register</a>
						<p class="text-center lg:text-start lg:text-xl">Already have an account? <a class="link" href="/signin">Login</a></p>
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
