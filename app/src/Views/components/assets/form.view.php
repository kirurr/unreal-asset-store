<?php

use Entities\Asset;
use Entities\Category;

/** @var Category[] $categories */
/** @var Asset $asset */
/** @var array $previousData */
/** @var string|null $errorMessage */
/** @var array $errors */
/** @var string $action */
/** @var bool $isEdit */
/** @var string $method */
?>

<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_method" value="<?= $method ?>">

	<label for="name">Name</label>
	<input type="text" name="name" id="name" value="<?= retrieveData($previousData, $asset, 'name') ?>">
	<span><?= $errors['name'] ?? '' ?></span>

	<label for="info">Info</label>
	<input type="text" name="info" id="info" value="<?= retrieveData($previousData, $asset, 'info') ?>">
	<span><?= $errors['info'] ?? '' ?></span>

	<label for="description">Description</label>
	<textarea name="description" id="description"><?= retrieveData($previousData, $asset, 'description') ?></textarea>
	<span><?= $errors['description'] ?? '' ?></span>

	<?php if (!$isEdit): ?>
		<label for="images">Images</label>
		<input type="file" name="images[]" id="images" multiple>
		<span><?= $errors['images'] ?? '' ?></span>
	<?php endif; ?>

	<label for="price">Price</label>
	<input type="number" name="price" id="price" value="<?= retrieveData($previousData, $asset, 'price') ?>">
	<span><?= $errors['price'] ?? '' ?></span>

	<label for="engine_version">Engine Version</label>
	<input type="text" name="engine_version" id="engine_version" value="<?= retrieveData($previousData, $asset, 'engine_version') ?>">
	<span><?= $errors['engine_version'] ?? '' ?></span>

	<label for="category_id">Category ID</label>
	<select name="category_id" id="category_id">
		<?php foreach ($categories as $category): ?>
		<option

			<?php if ($isEdit): ?>
				<?php if (isset($previousData['category_id']) && $previousData['category_id'] === $category->id): ?>
					selected
				<?php elseif ($category->id === $asset->category_id): ?>
					selected
				<?php endif; ?>
			<?php else: ?>
				<?php if (isset($previousData['category_id']) && $previousData['category_id'] === $category->id): ?>
					selected
				<?php endif; ?>
			<?php endif; ?>

		  	value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
		<?php endforeach; ?>
	</select>
	<span><?= $errors['category_id'] ?? '' ?></span>

	<button type="submit">submit</button>
	<p> <?= $errorMessage ?? '' ?></p>
</form>
