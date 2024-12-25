<?php

namespace Entities;

class AssetFilters
{
    public function __construct(
        public ?int $category_id,
        public ?int $user_id,
        public ?string $search,
        public ?string $engine_version,
        public ?int $interval,
        public ?bool $byNew,
        public ?bool $byPopular,
        public ?bool $asc,
        public ?int $minPrice,
        public ?int $maxPrice,
        public ?int $limit
    ) {
    }
}
