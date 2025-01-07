<?php

namespace Entities;

class AssetFilters
{
    public function __construct(
        public ?int $category_id = null,
        public ?int $user_id = null,
        public ?string $search = null,
        public ?string $engine_version = null,
        public ?int $interval = null,
        public ?bool $byNew = null,
        public ?bool $byPopular = null,
        public ?bool $asc = null,
        public ?int $minPrice = null,
        public ?int $maxPrice = null,
        public ?int $limit = null,
        public ?int $offset = null
    ) {}
}
