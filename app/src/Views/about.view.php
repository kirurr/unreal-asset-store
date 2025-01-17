<?php

use Entities\Category;

/** @var Category[] $trendingCategories */

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
	<header class="header">
		<? renderComponent('navbar', ['categories' => $trendingCategories]); ?>
	</header>
	<main>
		<section class="p-0 my-6">
			<h1>About Us</h1>
            <p>
                Welcome to <strong>Unreal Asset Store</strong>, your premier destination for high-quality Unreal Engine 
                assets! We are passionate about empowering developers, artists, and creators by providing them 
                with the tools they need to bring their visions to life.
            </p>
        </section>

        <section class="p-0 mb-6">
            <h2>Our Mission</h2>
            <p>
                At <strong>Unreal Asset Store</strong>, our mission is to simplify the creative process for game 
                developers and digital artists. We understand the challenges of finding the right assets that fit 
                your project’s needs, and we strive to offer a diverse range of high-quality, ready-to-use assets 
                that enhance your workflow and inspire your creativity.
            </p>
        </section>

        <section class="p-0 mb-6">
            <h2>What We Offer</h2>
            <ul class="list-disc list-inside">
                <li><strong>3D Models</strong>: From characters to environments, our models are designed to be 
                    versatile and easy to integrate.</li>
                <li><strong>Textures and Materials</strong>: Enhance your projects with our high-resolution textures 
                    and customizable materials.</li>
                <li><strong>Blueprints and Scripts</strong>: Save time with our pre-built blueprints and scripts 
                    that add functionality to your projects.</li>
                <li><strong>Animations</strong>: Bring your characters to life with our collection of animations 
                    tailored for various genres.</li>
                <li><strong>And More</strong></li>
            </ul>
        </section>

        <section class="p-0 mb-6">
            <h2>Our Commitment</h2>
            <p>
                Quality is at the heart of everything we do. We work closely with talented artists and developers 
                to ensure that every asset meets our high standards. Our team is dedicated to providing exceptional 
                customer service, and we are here to support you every step of the way.
            </p>
        </section>

        <section class="p-0 mb-6">
            <h2>Join Our Community</h2>
            <p>
                We believe in the power of collaboration and community. Join our growing community of creators, 
                share your projects, and connect with like-minded individuals. Follow us on social media and 
                subscribe to our newsletter for the latest updates, tips, and exclusive offers.
            </p>
        </section>
	</main>
	<? renderComponent('footer', ['categories' => $trendingCategories]); ?>
</body>

</html>