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

<form action="<?= $action ?>" method="post" enctype="multipart/form-data" class="flex flex-col gap-4">
	<input type="hidden" name="_method" value="<?= $method ?>">

	<div>
		<label class="label" for="name">name</label>
		<input required placeholder="Amazing 3D asset" class="input" type="text" name="name" id="name" value="<?= retrieveData($previousData, $asset, 'name') ?>">
		<span><?= $errors['name'] ?? '' ?></span>
	</div>

	<div>
		<label class="label" for="info">info</label>
		<textarea required class="textarea" placeholder="Small description" type="text" name="info" id="info"><?= retrieveData($previousData, $asset, 'info') ?></textarea>
		<span><?= $errors['info'] ?? '' ?></span>
	</div>

	<div>
		<label class="label" for="description">description</label>
		<textarea required name="description" id="description"><?= retrieveData($previousData, $asset, 'description') ?></textarea>
		<span><?= $errors['description'] ?? '' ?></span>
	</div>

	<div class="flex gap-4">
		<div class="w-1/2">
			<div>

				<label class="label" for="engine_version">engine version</label>
				<input class="input" type="text" placeholder="Keep empty if your asset is suitable for all versions" name="engine_version" id="engine_version" value="<?= retrieveData($previousData, $asset, 'engine_version') ?>">
				<span><?= $errors['engine_version'] ?? '' ?></span>
			</div>

			<div class="mt-4">
				<label class="label" for="price">price</label>
				<input required class="input" placeholder="Keep empty if your asset is free" type="number" name="price" id="price" value="<?= retrieveData($previousData, $asset, 'price') ?>">
				<span><?= $errors['price'] ?? '' ?></span>
			</div>
		</div>
		<div class="w-1/2">
			<?php if (!$isEdit): ?>
				<div class="mb-4">
					<label class="label" for="images">images</label>
					<input accept="image/*" type="file" name="images[]" id="images" multiple>
					<p>You can upload multiple images and change them later</p>
					<span><?= $errors['images'] ?? '' ?></span>
				</div>
			<?php endif; ?>

			<div>
				<label class="label" for="category_id">category</label>
				<select required class="w-fit select" name="category_id" id="category_id">
					<?php foreach ($categories as $category): ?>
						<option
							<?php if ($isEdit): ?>
							<?php if (isset($previousData['category_id']) && $previousData['category_id'] === $category->id): ?>
							selected
							<?php elseif ($category->id === $asset->category->id): ?>
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
			</div>
		</div>
	</div>

	<button class="button accent mx-auto" type="submit">submit</button>
	<p> <?= $errorMessage ?? '' ?></p>
</form>