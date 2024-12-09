<?php

namespace Entities;

class Asset
{
    /**
     * @param array<string> $images
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $info,
        public string $description,
        public array $images,
        public int $price,
        public int $engine_version,
        public int $category_id,
        public int $user_id,
        public int $created_at,
        public int $purchase_count = 0
    ) {
    }

    public function getImagesString(): string 
    {
        return implode(';', $this->images);
    }
}
