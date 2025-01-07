<?php
use Entities\Asset;

/** @var Asset[] $assets */
$topAsset = $assets[0];
?>

<div>
	<div class="flex gap-4 h-[35rem]">
		<div class="w-3/4">
			<div class="size-full flex flex-col relative">
				<img class="size-full absolute object-cover" src="<?= $topAsset->preview_image ?>" alt="<?= $topAsset->name ?>">
				<div class="mt-auto w-full mb-4 mx-4">
				<span class="block relative z-10"><?= $topAsset->name ?></span>
				</div>
			</div>
		</div>
		<div class="w-1/4 flex flex-col gap-2">
		<?php foreach ($assets as $asset): ?>
			<?php if ($asset === $topAsset) {
                continue;
            } ?>
		
			<img class="size-full object-cover" src="<?= $asset->preview_image ?>" alt="<?= $asset->name ?>">
		<?php endforeach; ?>
		</div>
	</div>
</div>
