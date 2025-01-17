<?php

namespace Entities;

use DateTime;

class Purchase
{
    public function __construct(
        public string $id,
        public string $asset_id,
        public string $user_id,
		public string $purchase_date,
    ) {}

    public function getFormatedPurchaseDate(): string
    {
        $date = new DateTime();
        $date->setTimestamp($this->purchase_date);

        return $date->format('d M Y');
    }
}
