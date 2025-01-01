<?php

namespace Entities;

class Purchase
{
    public function __construct(
        public string $id,
        public string $asset_id,
        public string $user_id,
		public string $purchase_date,
    ) {}
}
