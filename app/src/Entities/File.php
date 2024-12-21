<?php

namespace Entities;

class File
{
    public function __construct(
        public string $id,
        public string $name,
        public string $path,
		public string $version,
		public string $asset_id,
		public string $description,
        public int $size,
		public int $created_at,
    ) {
    }
}
