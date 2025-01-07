<?php
use Entities\AssetFilters;
use Entities\Category;

/** @var Category[] $categories */
/** @var array{ min: int, max: int } $prices */
/** @var AssetFilters $filters */
?>

<form action="/assets" method="get">
	<label for="category_id">Category</label>
	<select name="category_id" id="category_id">
		<option value="">All</option>
		<?php foreach ($categories as $category): ?>
		<option 
			<?php echo (($filters->category_id === $category->id) ? 'selected' : '') ?>
			value="<?= $category->id ?>">
			<?= $category->name ?>
		</option>
		<?php endforeach; ?>
	</select>

	<label for="search">Search</label>
	<input type="text" name="search" id="search" value="<?= $filters->search ?>">

	<label for="engine_version">Engine Version</label>
	<input type="text" name="engine_version" id="engine_version" value="<?= $filters->engine_version ?>">

	<label for="interval">Interval</label>
	<select name="interval" id="interval">
		<option value="">All time</option>
		<option 
			<?php echo (($filters->interval === 1) ? 'selected' : '') ?>
			value="1">Last 24 hours
		</option>
		<option 
			<?php echo (($filters->interval === 7) ? 'selected' : '') ?>
			value="7">Last 7 days
		</option>
		<option 
			<?php echo (($filters->interval === 30) ? 'selected' : '') ?>
			value="30">Last 30 days
		</option>
	</select>

	<label for="byNew">By New</label>
	<input type="checkbox" name="byNew" id="byNew" <?= $filters->byNew ? 'checked' : '' ?>>

	<label for="byPopular">By Popular</label>
	<input type="checkbox" name="byPopular" id="byPopular" <?= $filters->byPopular ? 'checked' : '' ?>>

	<label for="asc">Ascending</label>
	<input type="checkbox" name="asc" id="asc" <?= $filters->asc ? 'checked' : '' ?>>

	<label for="minPrice">Min Price</label>
	<input type="number" name="minPrice" id="minPrice" value="<?= $filters->minPrice ?? $prices['min'] ?>">
	<label for="maxPrice">Max Price</label>
	<input type="number" name="maxPrice" id="maxPrice" value="<?= $filters->maxPrice ?? $prices['max'] ?>">

	<label for="limit">Limit</label>
	<input type="number" name="limit" id="limit" value="<?= $filters->limit ?? 10 ?>">

	<button type="submit">Filter</button>
</form>
