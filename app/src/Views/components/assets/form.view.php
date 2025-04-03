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
		<textarea name="description" id="description"><?= retrieveData($previousData, $asset, 'description') ?></textarea>
		<span><?= $errors['description'] ?? '' ?></span>
	</div>

	<div class="grid grid-cols-2 gap-4 grid-rows-2">
		<div>
			<label class="label" for="engine_version">engine version</label>
			<input class="input" type="text" placeholder="Keep empty if your asset is suitable for all versions" name="engine_version" id="engine_version" value="<?= retrieveData($previousData, $asset, 'engine_version') ?>">
			<span><?= $errors['engine_version'] ?? '' ?></span>
		</div>

		<div>
			<label class="label" for="price">price</label>
			<input class="input" placeholder="Keep empty if your asset is free" type="number" name="price" id="price" value="<?= retrieveData($previousData, $asset, 'price') ?? '' ?>">
			<span><?= $errors['price'] ?? '' ?></span>
		</div>
		<?php if (!$isEdit): ?>
			<div class="col-span-2 lg:col-span-1">
				<label class="label" for="images">images</label>
				<input class="w-full" accept="image/*" type="file" name="images[]" id="images" multiple>
				<p class="hidden lg:block">You can upload multiple images and change them later</p>
				<span>
					<?php if (isset($errors['images'])): ?>
						<?php if (is_string($errors['images'])): ?>
							<?= $errors['images']; ?>
						<?php else: ?>
							<?php foreach ($errors['images'] as $error): ?>
								<?= $error ?><br>
							<?php endforeach; ?>
						<?php endif; ?>
					<?php endif; ?>
				</span>
			</div>
		<?php endif; ?>

		<div class="col-span-2 lg:col-span-1">
			<label class="label" for="category_id">category</label>
			<?php if ($categories): ?>
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
			<?php else: ?>
				<span>No categories found, <a href="/admin/categories/create" class="link">create new</a></span>
			<?php endif; ?>
			<span><?= $errors['category_id'] ?? '' ?></span>
		</div>
	</div>

	<button class="button accent mx-auto" type="submit">submit</button>
	<p> <?= $errorMessage ?? '' ?></p>
</form>