<?php
use Entities\Asset;

/** @var Asset[] $assets */
$topAsset = $assets[0] ?? null;
?>

<div>
	<div class="flex gap-4 h-[35rem]">
		<div class="w-[80%]">
			<div class="size-full flex flex-col relative rounded-xl overflow-hidden">
				<?php if ($topAsset): ?>
				<div class="size-full absolute z-10 bg-gradient-to-tr from-bg-color via-transparent to-transparent"></div>
				<img class="size-full absolute object-cover" src="<?= $topAsset->preview_image ?>" alt="<?= $topAsset->name ?>">
				<div class="mt-auto w-full relative z-10 p-8">
					<h1 class="block text-[3.5rem]"><?= $topAsset->name ?></h1>
					<p class="text-font-color/70 text-[1.5rem]"><?= $topAsset->info ?></p>
					<a href="assets/<?= $topAsset->id ?>" class="mt-12 button accent">See details</a>
				</div>
				<?php else: ?>
				<div class="size-full bg-secondary-bg-color"></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="w-[20%] grid grid-cols-1 grid-rows-4 gap-4">
		<?php foreach ($assets as $asset): ?>
			<?php if ($asset === $topAsset) {
                continue;
            } ?>
		
			<div class="relative flex flex-col rounded-xl overflow-hidden">
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
