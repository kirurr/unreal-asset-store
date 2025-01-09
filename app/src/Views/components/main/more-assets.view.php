<?php
use Entities\Asset;

/** @var Asset[] $assets */
/** @var string $currentVariant */
/** @var array{ string: array{ text: string, uri: string}} $links */
/** @var array<string, string> $variants */
$links = [
    'today' => ['text' => 'New for 24h', 'uri' => 'interval=1&byNew=on'],
    'new-week' => ['text' => 'New this week', 'uri' => 'interval=7&byNew=on'],
    'new-month' => ['text' => 'New this month', 'uri' => 'interval=30&byNew=on'],
    'popular-week' => ['text' => 'Popular this week', 'uri' => 'interval=7&byPopular=on'],
    'popular-month' => ['text' => 'Popular this month', 'uri' => 'interval=30&byPopular=on'],
    'popular-all' => ['text' => 'Popular all time', 'uri' => 'byPopular=on'],
];
$currentLink = $links[$_GET['variant'] ?? 'today'];
?>

<div>
	<h1 class="mb-4">More Assets</h1>
	<div class="bg-secondary-bg-color/50 p-2 rounded-xl shadow-lg">
		<ul class="flex gap-4 list-none mb-4">
			<?php foreach ($links as $key => $value): ?>
			<li class="more-assets-list <?= $value === $currentLink ? 'active' : '' ?>">
				<a class="p-2 block" href="/?variant=<?= $key ?>#more-assets" >
					<?= $value['text'] ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<ul class="grid grid-cols-4 mt-6 gap-6">
			<?php if (count($assets) === 0): ?>
				<li class="col-span-4 flex flex-col items-center justify-center">
					<p>No assets found :(</p>
				</li>
			<?php endif; ?>
			<?php foreach ($assets as $asset): ?>
				<li class="relative flex flex-col rounded-xl overflow-hidden shadow-lg">	
					<a href="/assets/<?= $asset->id ?>/" tabindex="-1" class="h-[55%] hover:scale-105 transition-all">
						<img src="<?= $asset->preview_image ?>" class="size-full object-cover" alt="<?= $asset->name ?>">
					</a>
					<div class="bg-bg-color/40 h-[45%] p-2 flex flex-col gap-4 relative z-10">
						<div>
							<h3 class="hover:text-font-color/50 transition-colors w-fit"><a href="/assets/<?= $asset->id ?>/"><?= $asset->name ?></a></h3>
							<a class="no-underline link" href="assets?category_id=<?= $asset->category->id ?>"><?= $asset->category->name ?></a>
							<p class="text-font-color/70 text-sm">
								Author
								<a class="link no-underline" href="/assets?user_id=<?= $asset->user->id ?>"><?= $asset->user->name ?></a>
							</p>

							<?php
                            $date = new DateTime();
                            $date->setTimestamp($asset->created_at);
                            ?>

							<p class="text-font-color/70 text-sm">Uploaded <?= $date->format('d M Y') ?></p>
							<?php if ($asset->price > 0): ?>
								<p class="text-font-color/70 text-sm mt-2"><?= $asset->price ?> USD</p>
							<?php else: ?>
								<p class="text-green-300/70 text-sm mt-2">Free asset</p>
							<?php endif; ?>
						</div>
						<div>
							<p class="text-font-color/70 text-md text-ellipsis break-words line-clamp-3"><?= $asset->info ?></p>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="mt-8">
<a class="block mx-auto button accent text-lg p-2" href="/assets?<?= $currentLink['uri'] ?>"> See more <?php echo(strtolower($currentLink['text'])) ?></a>
		</div>

	</div>
</div>
