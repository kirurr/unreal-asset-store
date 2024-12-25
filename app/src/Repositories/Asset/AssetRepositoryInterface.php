<?php

namespace Repositories\Asset;

use Entities\Asset;

interface AssetRepositoryInterface
{
    public function getById(string $id): ?Asset;

    /**
     * @return ?Asset[]
     */
	public function getAssets(
		int $category_id = null,
        int $user_id = null,
		string $search = null,
		string $engine_version = null,
        int $interval = null,
        bool $byNew = null,
        bool $byPopular = null,
        bool $asc = null,
        int $minPrice = null,
		int $maxPrice = null,
		int $limit = null,
    ): array;
     
    /**
     * @return ?Asset[]
     */
    public function create(string $id, string $name, string $info, string $description, string $preview_image, int $price, string $engine_version, int $category_id, int $user_id): void;
    public function update(Asset $asset): void;
    public function delete(string $id): void;
    public function incrementPurchasedCount(string $id): void;
    public function decrementPurchasedCount(string $id): void;
}
