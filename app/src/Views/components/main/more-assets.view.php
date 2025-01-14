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
$currentLink = $links[$_GET['variant'] ?? 'new-week'];
?>

<div>
	<h1 class="mb-4">more ajsets</h1>
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
				<?php renderComponent('assets/asset-card', ['asset' => $asset]); ?>
			<?php endforeach; ?>
		</ul>
		<?php if (count($assets) > 0): ?>
		<div class="mt-8">
			<a class="block mx-auto button accent text-lg p-2" href="/assets?<?= $currentLink['uri'] ?>"> See more <?php echo(strtolower($currentLink['text'])) ?></a>
		</div>
		<?php endif; ?>
	</div>
</div>
