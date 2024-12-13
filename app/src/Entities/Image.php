<?php

namespace Entities;

class Image
{
    public function __construct(
        public int $id,
        public string $asset_id,
        public int $image_order,
        public string $path
    ) {
    }
}
