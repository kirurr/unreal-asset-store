<?php

use Entities\Review;

/** @var Review $review */
/** @var array{ title: string, review: string, posititive: string, negative: string, is_positive: string } $errors */
/** @var array{ title: string, review: string, posititive: string, negative: string, is_positive: string } $previousData */
/** @var string $errorMessage */
/** @var string $path */
?>

<form action="<?= $path . $review->id ?>/" method="post" class="text-start flex flex-col gap-4 max-w-screen-sm mx-auto bg-secondary-bg-color/50 p-2 rounded-xl shadow-lg">
    <input type="hidden" name="_method" value="PUT">

    <div>
        <label class="label" for="title">title</label>
        <input class="input" placeholder="Title" type="text" name="title" value="<?= $previousData['title'] ?? $review->title ?>">
        <span class="mt-4"><?= $errors['title'] ?? '' ?></span>
    </div>

    <div>
        <label class="label" for="review">review</label>
        <textarea name="review" placeholder="Your review" class="textarea" rows="4" cols="50"><?= $previousData['review'] ?? $review->review ?></textarea>
        <span class="mt-4"><?= $errors['review'] ?? '' ?></span>
    </div>

    <div>
        <label class="label" for="positive">positive</label>
        <textarea class="textarea" name="positive" placeholder="Something positive about asset" rows="4" cols="50"><?= $previousData['positive'] ?? $review->positive ?></textarea>
        <span class="mt-4"><?= $errors['positive'] ?? '' ?></span>
    </div>

    <div>
        <label class="label" for="negative">negative</label>
        <textarea class="textarea" name="negative" rows="4" placeholder="Something negative about asset" cols="50"><?= $previousData['negative'] ?? $review->negative ?></textarea>
        <span class="mt-4"><?= $errors['negative'] ?? '' ?></span>
    </div>

    <label class="inline-flex items-center cursor-pointer">
        <input class="sr-only peer" type="checkbox" name="byPopular" id="byPopular"
            <?php if (isset($previousData['is_positive'])): ?>
            <?= $previousData['is_positive'] ? 'checked' : '' ?>
            <?php else: ?>
            <?= $review->is_positive ? 'checked' : '' ?>
            <?php endif; ?>>
        <div class="outline outline-2 outline-offset-2 outline-transparent transition-all relative w-11 h-6 bg-font-color/70 peer-focus:outline peer-focus:outline-offset-2 peer-focus:outline-2 peer-focus:outline-accent-color rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-accent-color"></div>
        <span class="label ml-4">is positive</span>
    </label>

    <span><?= $errors['is_positive'] ?? '' ?></span>
    <?= $errorMessage ?? '' ?>
    <input class="button accent mx-auto" type="submit" value="update review">
</form>