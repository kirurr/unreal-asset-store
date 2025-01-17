<?php

namespace Entities;

class Category
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
		public int $asset_count
    ) {}
}
