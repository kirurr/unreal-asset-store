<?php

use Entities\AssetFilters;
use Entities\Category;

/** @var Category[] $categories */
/** @var array{ min: int, max: int } $prices */
/** @var AssetFilters $filters */
?>

<form id="filters" action="/assets" method="get" class="mb-8 bg-bg-color/50 p-2 rounded-xl shadow-lg">
	<div class="lg:flex hidden w-full lg:flex-row flex-col gap-4 items-center">
		<div>
			<label class="label" for="search">Search</label>
			<input class="input" placeholder="Search in assets" type="text" name="search" id="search" value="<?= $filters->search ?>">
		</div>
		<div>
			<label class="label" for="interval">Interval</label>
			<select class="select" name="interval" id="interval">
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
		</div>
		<div>
			<label class="label" for="limit">Limit</label>
			<input class="input" placeholder="10" type="number" name="limit" id="limit" value="<?= ($filters->limit == 10) ? '' : $filters->limit ?>">
		</div>
		<button class="button accent ml-auto text-base px-4 py-2" type="submit">Apply filters</button>
	</div>
	<details class="filters-details lg:mt-8">
		<summary class="filters-summary font-medium">Filters</summary>
		<div class="lg:hidden flex w-full lg:flex-row flex-col gap-4 items-start lg:items-center">
			<div>
				<label class="label" for="search">Search</label>
				<input class="input" placeholder="Search in assets" type="text" name="search" id="search" value="<?= $filters->search ?>">
			</div>
			<div>
				<label class="label" for="interval">Interval</label>
				<select class="select" name="interval" id="interval">
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
			</div>
			<div>
				<label class="label" for="limit">Limit</label>
				<input class="input" placeholder="10" type="number" name="limit" id="limit" value="<?= ($filters->limit == 10) ? '' : $filters->limit ?>">
			</div>
		</div>
		<div class="flex flex-col lg:flex-row gap-4">
			<div class="flex flex-col gap-4">
				<label class="label" for="category_id">Category</label>
				<select class="select" name="category_id" id="category_id">
					<option value="">All</option>
					<?php foreach ($categories as $category): ?>
						<option
							<?php echo (($filters->category_id === $category->id) ? 'selected' : '') ?>
							value="<?= $category->id ?>">
							<?= $category->name ?>
						</option>
					<?php endforeach; ?>
				</select>

				<label class="label" for="engine_version">Engine Version</label>
				<input class="input w-fit" placeholder="By all versions" type="text" name="engine_version" id="engine_version" value="<?= $filters->engine_version ?>">
			</div>

			<div class="flex flex-col gap-4">
				<label class="inline-flex items-center cursor-pointer">
					<input class="sr-only peer" type="checkbox" name="byNew" id="byNew" <?= $filters->byNew ? 'checked' : '' ?>>
					<div class="outline outline-2 outline-offset-2 outline-transparent transition-all relative w-11 h-6 bg-font-color/70 peer-focus:outline peer-focus:outline-offset-2 peer-focus:outline-2 peer-focus:outline-accent-color rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-accent-color"></div>
					<span class="ms-3 text-sm font-medium text-font-color dark:text-gray-300">By new</span>
				</label>



				<label class="inline-flex items-center cursor-pointer">
					<input class="sr-only peer" type="checkbox" name="byPopular" id="byPopular" <?= $filters->byPopular ? 'checked' : '' ?>>
					<div class="outline outline-2 outline-offset-2 outline-transparent transition-all relative w-11 h-6 bg-font-color/70 peer-focus:outline peer-focus:outline-offset-2 peer-focus:outline-2 peer-focus:outline-accent-color rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-accent-color"></div>
					<span class="ms-3 text-sm font-medium text-font-color dark:text-gray-300">By popular</span>
				</label>


				<label class="inline-flex items-center cursor-pointer">
					<input class="sr-only peer" type="checkbox" name="asc" id="asc" <?= $filters->asc ? 'checked' : '' ?>>
					<div class="outline outline-2 outline-offset-2 outline-transparent transition-all relative w-11 h-6 bg-font-color/70 peer-focus:outline peer-focus:outline-offset-2 peer-focus:outline-2 peer-focus:outline-accent-color rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-accent-color"></div>
					<span class="ms-3 text-sm font-medium text-font-color dark:text-gray-300">Ascending</span>
				</label>
			</div>

			<div>
				<label class="label" for="minPrice">Min price</label>
				<input class="input mb-4" type="number" name="minPrice" id="minPrice" value="<?= ($filters->minPrice == $prices['min']) ? '' : $filters->minPrice ?>" placeholder="<?= $prices['min'] ?>">

				<label class="label" for="maxPrice">Max price</label>
				<input class="input mb-4" type="number" name="maxPrice" id="maxPrice" value="<?= ($filters->maxPrice == $prices['max']) ? '' : $filters->maxPrice ?>" placeholder="<?= $prices['max'] ?>">

				<label class="inline-flex items-center cursor-pointer">
					<input class="sr-only peer" type="checkbox" name="byFree" id="byFree" <?= $filters->byFree ? 'checked' : '' ?>>
					<div class="outline outline-2 outline-offset-2 outline-transparent transition-all relative w-11 h-6 bg-font-color/70 peer-focus:outline peer-focus:outline-offset-2 peer-focus:outline-2 peer-focus:outline-accent-color rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-accent-color"></div>
					<span class="ms-3 text-sm font-medium text-font-color dark:text-gray-300">Show only free assets</span>
				</label>
			</div>
			<button class="button block lg:hidden accent ml-auto text-base px-4 py-2" type="submit">Apply filters</button>
		</div>
	</details>
</form>