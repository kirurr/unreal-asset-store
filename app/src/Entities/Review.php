<?php

namespace Entities;

class Review
{
    public function __construct(
        public int $id,
        public string $asset_id,
		public User $user,
		public string $title,
        public string $review,
        public ?string $positive,
        public ?string $negative,
        public int $created_at,
        public bool $is_positive,
    ) {}
}
