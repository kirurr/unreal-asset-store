<?php
use Entities\Asset;

/** @var Asset[] $assets */
?>

<div>
	<div class="flex gap-4 h-[35rem]">
		<div class="w-[80%] slider overflow-hidden rounded-xl">
			<ul class="slides relative size-full flex">
				<?php foreach ($assets as $asset): ?>
				<li class="slide min-w-full size-full flex flex-col relative rounded-xl overflow-hidden shadow-lg">
					<div class="size-full absolute z-10 bg-gradient-to-tr from-bg-color via-transparent to-transparent"></div>
					<img class="size-full absolute object-cover" src="<?= $asset->preview_image ?>" alt="<?= $asset->name ?>">
					<div class="mt-auto w-full relative z-10 p-8">
						<h1 class="block text-[3.5rem]"><?= $asset->name ?></h1>
						<p class="text-font-color/70 text-[1.5rem]"><?= $asset->info ?></p>
						<a href="assets/<?= $asset->id ?>" class="mt-12 button accent">See details</a>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="thumbnails w-[20%] grid grid-cols-1 grid-rows-4 gap-4">
		<?php foreach ($assets as $key => $asset): ?>
			<div class="thumbnail transition-all relative flex flex-col rounded-xl overflow-hidden shadow-lg" data-index="<?= $key ?>">
				<div class="size-full absolute z-10 bg-gradient-to-tr from-bg-color via-transparent to-transparent"></div>
				<img class="object-cover size-full absolute" src="<?= $asset->preview_image ?>" alt="<?= $asset->name ?>">
				<div class="mt-auto w-full p-4">
					<span class="block relative z-10 overflow-hidden whitespace-nowrap overflow-ellipsis"><?= $asset->name ?></span>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</div>
