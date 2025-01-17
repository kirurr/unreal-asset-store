<?php

use Entities\Category;
use Entities\File;

/** @var Category[] $categories */
/** @var File[] $files */
/** @var Asset $asset */

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php renderComponent('head'); ?>
		<title>files</title>
	</head>
	<body class="justify-normal">
		<header>
			<?php renderComponent('admin/navbar'); ?>
		</header>
		<main>
			<section>
				<div class="p-2 rounded-xl shadow-lg bg-secondary-bg-color/50">
					<div class="flex flex-col lg:flex-row items-center">
						<h1>files for <?= $asset->name ?></h1>
						<div class="ml-auto flex items-center gap-4">
							<a class="link" href="/admin/assets/<?= $asset->id ?>/">back to asset</a>
							<a class="button" href="/admin/assets/<?= $asset->id ?>/files/create">create file</a>
						</div>
					</div>
					<?php if(count($files) > 0): ?>
					<div class="overflow-x-scroll">
					<table class="table-auto w-full divide-y-2 divide-font-color/20">
						<thead>
							<tr>
								<th class="p-4 text-start">
									name
								</th>
								<th class="p-4 text-start">
									version
								</th>
								<th class="p-4 text-start">
									description
								</th>
								<th class="p-4 text-start">
									size
								</th>
								<th class="p-4 text-start">
									created at
								</th>
								<th class="p-4 text-start"></th>
							</tr>
						</thead>
						<tbody class="divide-y-2 divide-font-color/5">
							<?php foreach ($files as $file): ?>
							<tr>
								<td class="p-4"><?= $file->name ?></td>
								<td class="p-4"><?= $file->version ?></td>
								<td class="p-4"><?= $file->description ?></td>
								<td class="p-4"><?= $file->getFormatedSize() ?></td>
								<td class="p-4"><?= $file->getFormatedCreatedAt() ?></td>
								<td class="p-4"><a class="link" href="/admin/assets/<?= $asset->id ?>/files/<?= $file->id ?>">Edit </a></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					</div>
					<?php else: ?>
						<p class="text-center">no files for this asset</p>
					<?php endif; ?>
				</div>
			</section>
		</main>
	</body>
</html>

