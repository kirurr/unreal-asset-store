<?php
use Entities\Asset;

/** @var Asset[] $assets */
?>

<div>
	<div class="flex gap-4 lg:h-[35rem] h-[20rem]">
		<div id="main-carousel" class="splide lg:w-[80%] w-full slider overflow-hidden lg:rounded-xl">
			<div class="splide__track size-full">
				<ul class="splide__list relative size-full flex">
					<?php foreach ($assets as $asset): ?>
					<li class="splide__slide min-w-full size-full flex flex-col relative lg:rounded-xl overflow-hidden shadow-lg">
						<div class="size-full absolute z-10 bg-gradient-to-tr from-bg-color via-transparent to-transparent"></div>
						<img class="size-full absolute object-cover" src="<?= $asset->preview_image ?>" alt="<?= $asset->name ?>">
						<div class="mt-auto w-full relative z-10 p-2 lg:p-8">
							<h1 class="block lg:text-[3.5rem]"><?= $asset->name ?></h1>
							<p class="text-font-color/70 lg:text-[1.5rem]"><?= $asset->info ?></p>
							<a href="assets/<?= $asset->id ?>" class="lg:mt-12 text-base lg:text-xl button accent">See details</a>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div id="thumbnails-carousel" class="hidden lg:block splide w-[20%]">
			<div class="splide__track size-full">
				<ul class="splide__list size-full grid grid-cols-1 grid-rows-4 gap-4">
					<?php foreach ($assets as $key => $asset): ?>
					<li class="splide__slide thumbnail transition-all border-2 border-transparent relative flex flex-col rounded-xl overflow-hidden shadow-lg">
						<div class="size-full absolute z-10 bg-gradient-to-tr from-bg-color via-transparent to-transparent"></div>
						<img class="object-cover size-full absolute" src="<?= $asset->preview_image ?>" alt="<?= $asset->name ?>">
						<div class="mt-auto w-full p-4">
							<span class="block relative z-10 overflow-hidden whitespace-nowrap overflow-ellipsis"><?= $asset->name ?></span>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
