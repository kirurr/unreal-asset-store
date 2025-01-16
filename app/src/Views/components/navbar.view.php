<?php
use Services\Session\SessionService;

$session = SessionService::getInstance();

/** @var array{ id: int, name: string, email: string } $user */
/** @var Category[] $categories */

$user = $session->getUser();
?>

<nav>
	<ul class="navbar grid grid-cols-3 justify-items-center py-4 px-16 rounded-lg gap-6">
		<div class="justify-self-start">
			<li class="ml-auto">
				<a href="/" class="font-semibold">Home</a>
			</li>
		</div>
		<div class="flex gap-6">
			<li class="sublist-wrapper">
				<a href="#" class="sublist-toggle font-semibold flex items-center">
					Assets
					<svg class="size-5 relative z-[-1] flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
						<path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
					</svg>
				</a>
				<ul class="sublist">
					<li><a tabindex="-1" href="/assets">All</a></li>
					<li><a tabindex="-1" href="/assets?byNew=on">New</a></li>
					<li><a tabindex="-1" href="/assets?byNew=on&ByPopular=on&interval=30">Trending</a></li>
					<li><a tabindex="-1" href="/assets?byPopular=on">Top files (all time)</a></li>
					<li><a tabindex="-1" href="/assets?byFree=on">Free assets</a></li>
				</ul>
			</li>
			<li class="sublist-wrapper">
				<a href="#"class="sublist-toggle flex items-center font-semibold">
					Categories
					<svg class="size-5 flex-none relative z-[-1] text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
						<path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
					</svg>
				</a>
				<ul class="sublist">
					<?php foreach ($categories as $category): ?>
						<li><a href="/assets/?category_id=<?= $category->id ?>"><?= $category->name ?></a></li>
					<?php endforeach; ?>
					<li><a href="/categories">All categories</a></li>
				</ul>
			</li>
		</div>
		<div class="justify-self-end flex gap-6">
			<? if($user): ?>
					<? if($user['role'] === 'admin'): ?>
					<li><a href="/admin" class="font-semibold">Admin</a></li>
					<? endif ?>
				<li><a href="/profile" class="font-semibold">Profile</a></li>
			<? else:?>
				<li><a href="/signin" class="font-semibold">Sign in</a></li>
			<? endif ?>
		</div>
	</ul>
</nav>
