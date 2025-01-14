<?php

use Entities\Asset;

/** @var Asset $asset */
?>
<li class="relative flex flex-col rounded-xl overflow-hidden shadow-lg">
    <a href="/assets/<?= $asset->id ?>/" tabindex="-1" class="h-[55%] hover:scale-105 transition-all">
        <img src="<?= $asset->preview_image ?>" class="size-full min-h-[15rem] object-cover" alt="<?= $asset->name ?>">
    </a>
    <div class="bg-bg-color/40 h-[45%] p-2 flex flex-col gap-4 relative z-10">
        <div>
            <h3 class="hover:text-font-color/50 transition-colors w-fit"><a href="/assets/<?= $asset->id ?>/"><?= $asset->name ?></a></h3>
            <a class="no-underline link" href="assets?category_id=<?= $asset->category->id ?>"><?= $asset->category->name ?></a>
            <p class="text-font-color/70 text-sm">
                Author
                <a class="link no-underline" href="/assets?user_id=<?= $asset->user->id ?>"><?= $asset->user->name ?></a>
            </p>

            <?php
            $date = new DateTime();
            $date->setTimestamp($asset->created_at);
            ?>

            <p class="text-font-color/70 text-sm">Uploaded <?= $date->format('d M Y') ?></p>
            <?php if ($asset->price > 0): ?>
                <p class="text-font-color/70 text-sm mt-2"><?= $asset->price ?> USD</p>
            <?php else: ?>
                <p class="text-green-300/70 text-sm mt-2">Free asset</p>
            <?php endif; ?>
        </div>
        <div>
            <p class="text-font-color/70 text-md text-ellipsis break-words line-clamp-3"><?= $asset->info ?></p>
        </div>
    </div>
</li>