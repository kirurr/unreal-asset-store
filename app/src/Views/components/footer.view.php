<?php
use Entities\Category;

/** @var Category $categories */
?>
<footer class="bg-secondary-bg-color/70 text-font-color/60">
	<section class="py-8 grid grid-cols-3 divide-x-2 divide-bg-color/40">
		<div class="px-4">
			<h3>Assets</h3>
			<ul>
				<li><a class="hover:text-font-color/50 transition-colors" href="/assets">All assets</a></li>
				<li><a class="hover:text-font-color/50 transition-colors" href="/assets?byNew=on">New assets</a></li>
				<li><a class="hover:text-font-color/50 transition-colors" href="/assets?byNew=on&ByPopular=on&interval=30">Trending assets</a></li>
				<li><a class="hover:text-font-color/50 transition-colors" href="/assets?byPopular=on">Top assets (all time)</a></li>
				<li><a class="hover:text-font-color/50 transition-colors" href="/assets?byFree=on">Free assets</a></li>
			</ul>
		</div>
		<div class="px-4">
			<h3>Categories</h3>
			<ul>
				<?php foreach ($categories as $category): ?>
				<li><a class="hover:text-font-color/50 transition-colors" href="/assets?category_id=<?= $category->id ?>"><?= $category->name ?></a></li>
				<?php endforeach; ?>
				<li><a class="hover:text-font-color/50 transition-colors" href="/categories">Browse all categories</a></li>
			</ul>
		</div>
		<div class="px-4">
			<h3>About</h3>
			<ul>
				<li><a class="hover:text-font-color/50 transition-colors" href="/about">About</a></li>
				<li><a class="hover:text-font-color/50 transition-colors" href="/privacy">Privacy</a></li>
				<li><a class="hover:text-font-color/50 transition-colors" href="/terms">Terms</a></li>
		</div>
	</section>
</footer>
