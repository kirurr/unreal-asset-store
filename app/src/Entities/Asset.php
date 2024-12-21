<?php

namespace Entities;

class Asset
{
    /**
     * @param array<Image> $images
     */
    public function __construct(
        public string $id,
        public string $name,
        public string $info,
        public string $description,
        public array $images,
		public string $preview_image,
        public int $price,
        public string $engine_version,
        public int $category_id,
        public int $user_id,
        public int $created_at,
        public int $purchase_count = 0,
    ) {
    }
}
