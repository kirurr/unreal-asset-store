<?php
use Entities\Asset;

/** @var Asset[] $assets */
/** @var string $currentVariant */
/** @var array{ string: array{ text: string, uri: string}} $links */
/** @var array<string, string> $variants */

$links = [
	'today' => ['text'=>'new today', 'uri' => 'interval=1&byNew=on'],
    'new-week' => ['text' => 'new this week', 'uri' => 'interval=7&byNew=on' ],
    'new-month' => ['text' => 'new this month', 'uri' => 'interval=30&byNew=on' ],
    'popular-week' => ['text' => 'popular this week', 'uri' => 'interval=7&byPopular=on' ],
    'popular-month' => ['text' => 'popular this month', 'uri' => 'interval=30&byPopular=on' ],
    'popular-all' => ['text' => 'popular all time', 'uri' => 'byPopular=on' ],
];
$currentLink = $links[$_GET['variant'] ?? 'today'];
?>

<div>
	<h1>More Assets</h1>
	<ul class="flex gap-4 list-none">
		<?php foreach ($links as $key => $value): ?>
		<li>
			<a class="<?= $value === $currentLink ? 'bg-accent-color' : '' ?>" href="/?variant=<?= $key ?>#more-assets" >
				<?= $value['text'] ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
	<ul class="grid grid-cols-4 mt-2 gap-4">
		<?php foreach ($assets as $asset): ?>
			<li class="aspect-square relative flex flex-col">
				<img src="<?= $asset->preview_image ?>" class="absolute inset-0 size-full" alt="<?= $asset->name ?>">
				<a class="z-10 relative block mt-auto" href="/assets/<?= $asset->id ?>/"><?= $asset->name ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
	<a href="/assets?<?= $currentLink['uri'] ?>"> See all <?= $currentLink['text'] ?></a>
</div>
