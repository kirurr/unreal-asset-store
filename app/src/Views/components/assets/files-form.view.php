<?php

use Entities\File;

/**
 * @var File $file
 * @var string $errorMessage
 * @var array $previousData
 * @var array $errors
 * @var string $path
 * @var string $type
 */
?>

<div class="p-2 rounded-xl shadow-lg bg-secondary-bg-color/50 max-w-screen-sm mx-auto">
	<form class="flex flex-col gap-4" action="<?= $path ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="_method" value="<?= $type === 'create' ? 'post' : 'put' ?>">
		<?php if ($type === 'edit'): ?>
		<input type="hidden" name="path" value="<?= $file->path ?>">
		<?php endif; ?>

		<div>
			<label class="label" for="name">name</label>
			<input required placeholder="Name of your file" class="input" type="text" name="name" value="<?= retrieveData($previousData, $file, 'name') ?>">
			<span><?= $errors['name'] ?? '' ?></span>
		</div>

		<div>
			<label class="label" for="version">version</label>
			<input required placeholder="Version of your file" class="input" type="text" name="version" value="<?= retrieveData($previousData, $file, 'version') ?>">
			<span><?= $errors['version'] ?? '' ?></span>
		</div>

		<div>
			<label class="label" for="description">description</label>
			<textarea placeholder="description of your file" class="textarea" required name="description"><?= retrieveData($previousData, $file, 'description') ?></textarea>
			<span><?= $errors['description'] ?? '' ?></span>
		</div>

		<div>
			<label class="label" for="file">upload file</label>
			<input <?= $type === 'create' ? 'required' : '' ?> type="file" name="file" id="file">
			<?php if ($type === 'edit'): ?>
			<p class="text-font-color/70 text-sm font-medium">uploading new file is not necessary</p>
			<?php endif; ?>
			<span><?= $errors['file'] ?? '' ?></span>
		</div>

		<button class="button accent mx-auto" type="submit">submit</button>
		<p><?php echo $errorMessage ?? '' ?></p>
	</form>
	<?php if ($type === 'edit'): ?>
	<form class="w-full" action="<?= $path ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="_method" value="delete">
		<button class="block link text-red-500/80 mx-auto" type="submit">delete</button>
	</form>
</div>
<?php endif; ?>
