<?php
use Entities\Asset;
use Entities\Category;
use Entities\Image;

/** @var Category[] $trendingCategories */
/** @var Image[] $images */
/** @var Asset $asset */
/** @var string|null $errorMessage */
/** @var string $asset_id */
/** @var $previewImage Image */
$previewImageKey = array_search($asset->preview_image, array_column($images, 'path'));
$previewImage = $images[$previewImageKey];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php renderComponent('head') ?>
		<title>Images for asset</title>
	</head>
	<body>
		<header>
			<?php renderComponent('navbar', ['categories' => $trendingCategories]) ?>
		</header>
		<main>
			<section class="max-w-screen-md text-center">
				<h1>images for <?= $asset->name ?></h1>
				<form class="my-8" action="/profile/assets/<?php echo $asset_id ?>/images/" method="post" enctype="multipart/form-data">
					<h2 class="mb-2">add new images</h2>
					<p>they are going to be added to the end of the list</p>
					<input type="hidden" name="_method" value="post">
					<input type="hidden" name="_last_order" value="<?= $images[array_key_last($images)]->image_order ?>">
					<input required type="file" class="mx-auto block w-fit" name="images[]" accept="image/*" multiple>
					<button class="button mt-2 mx-auto" type="submit">add images</button>
				</form>
				<a href="/profile/assets/<?= $asset->id ?>" class="link">back to asset</a>
			</section>
			<section class="max-w-screen-md pt-0">
				<p><?php echo $errorMessage ?? '' ?></p>
				<div class="p-2 rounded-xl bg-secondary-bg-color/50 shadow-lg mb-4">
					<h2>preview image</h2>
					<div>
						<img class="w-full h-auto rounded-xl" src="<?= $previewImage->path ?>" alt="preview image">
						<form class="flex flex-col gap-4 mt-4" action="/profile/assets/<?= $asset_id ?>/images/" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_method" value="put">
							<input type="hidden" name="path" value="<?php echo $previewImage->path ?>">
							<input type="hidden" name="image_order" value="<?php echo $previewImage->image_order ?>">
							<input type="hidden" name="id" value="<?php echo $previewImage->id ?>">

							<div>
								<label for="preview-image" class="label">new image</label>
								<input required id="preview-image" accept="image/*" type="file" name="images">
							</div>
							<button class="button" type="submit">update preview image</button>
						</form>
					</div>
				</div>
				<ul class="flex flex-col gap-4 list-none">
					<?php foreach ($images as $key => $image): ?>
					<li class="p-2 rounded-xl bg-secondary-bg-color/50 shadow-lg">
						<div>
							<img class="w-full h-auto rounded-xl" src="<?= $image->path ?>" alt="preview image">
							<form class="flex gap-4 mt-4 items-center" action="/profile/assets/<?= $asset_id ?>/images/" method="post" enctype="multipart/form-data">
								<input type="hidden" name="_method" value="put">
								<input type="hidden" name="path" value="<?php echo $image->path ?>">
								<input type="hidden" name="image_order" value="<?php echo $image->image_order ?>">
								<input type="hidden" name="id" value="<?php echo $image->id ?>">

								<div>
									<label for="image-<?= $key ?>" class="label">new image</label>
									<input required id="image-<?= $key ?>" accept="image/*" type="file" name="images">
								</div>
								<button class="button" type="submit">update image</button>
							</form>
							<div class="flex gap-4 mt-4">
								<?php if ($asset->preview_image !== $image->path): ?>
								<form action="/profile/assets/<?php echo $asset_id ?>/images/" method="post">
									<input type="hidden" name="_method" value="delete">
									<input type="hidden" name="id" value="<?php echo $image->id ?>">
									<button class="button bg-red-500/80 hover:bg-red-500/50" type="submit">delete image</button>
								</form>
								<?php endif; ?>
								<?php if ($asset->preview_image === $image->path): ?>
								<span>this is preview image</span>
								<?php else: ?>
								<form action="/profile/assets/<?php echo $asset_id ?>/images/" method="post">
									<input type="hidden" name="_method" value="patch">
									<input type="hidden" name="id" value="<?php echo $image->id ?>">
									<button class="button" type="submit">set as preview image</button>
								</form>
								<?php endif; ?>
							</div>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
			</section>
		</main>
		<?php renderComponent('footer', ['categories' => $trendingCategories]) ?>
	</body>
</html>
