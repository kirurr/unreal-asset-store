<div>
	<h1>Top Assets</h1>
	<ul>
		<?php foreach ($assets as $asset) : ?>
			<li>
				<a href="/assets/<?= $asset->id ?>">
					<?= $asset->name ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
