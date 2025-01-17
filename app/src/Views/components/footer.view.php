<?php

use Entities\Category;
use Services\Session\SessionService;

/** @var Category $categories */
$session = SessionService::getInstance();
$user = $session->getUser();
?>
<footer class="bg-secondary-bg-color/70 text-font-color/60">
	<section class="py-8 px-2 lg:px-0 grid gap-y-4 lg:gap-y-0 grid-cols-2 lg:grid-cols-4 justify-items-start lg:justify-items-center">
		<div>
			<h3>Assets</h3>
			<ul>
				<li><a class="hover:text-font-color/50 transition-colors" href="/assets">All assets</a></li>
				<li><a class="hover:text-font-color/50 transition-colors" href="/assets?byNew=on">New assets</a></li>
				<li><a class="hover:text-font-color/50 transition-colors" href="/assets?byNew=on&ByPopular=on&interval=30">Trending assets</a></li>
				<li><a class="hover:text-font-color/50 transition-colors" href="/assets?byPopular=on">Top assets (all time)</a></li>
				<li><a class="hover:text-font-color/50 transition-colors" href="/assets?byFree=on">Free assets</a></li>
			</ul>
		</div>
		<div>
			<h3>Categories</h3>
			<ul>
				<?php foreach ($categories as $category): ?>
					<li><a class="hover:text-font-color/50 transition-colors" href="/assets?category_id=<?= $category->id ?>"><?= $category->name ?></a></li>
				<?php endforeach; ?>
				<li><a class="hover:text-font-color/50 transition-colors" href="/categories">Browse all categories</a></li>
			</ul>
		</div>
		<div>
			<h3>About</h3>
			<ul>
				<li><a class="hover:text-font-color/50 transition-colors" href="/about">About</a></li>
				<li><a class="hover:text-font-color/50 transition-colors" href="/terms">Terms</a></li>
			</ul>
		</div>
		<div>
			<?php if ($user): ?>
				<h3>Account</h3>
				<ul>
					<li><a class="hover:text-font-color/50 transition-colors" href="/logout">Logout</a></li>
					<li><a class="hover:text-font-color/50 transition-colors" href="/profile">Profile</a></li>
				</ul>
			<?php else: ?>
				<h3>Account</h3>
				<ul>
					<li><a class="hover:text-font-color/50 transition-colors" href="/login">Login</a></li>
					<li><a class="hover:text-font-color/50 transition-colors" href="/signup">Register</a></li>
				</ul>
			<?php endif; ?>
		</div>
	</section>
</footer>