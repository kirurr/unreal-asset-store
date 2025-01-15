<?php

namespace Repositories\Asset;

use Entities\Asset;
use Entities\AssetFilters;
use PDOStatement;

interface AssetRepositoryInterface
{
	public function buildQuery(AssetFilters $filters, bool $isCount = false): PDOStatement;

    public function getById(string $id): ?Asset;

	/**
	 * @return ?Asset[]
	 */
	public function getAssets(PDOStatement $stmt): array;

	public function countAssets(PDOStatement $stmt): int;
     
    /**
     * @return ?Asset[]
     */
    public function create(string $id, string $name, string $info, string $description, string $preview_image, int $price, string $engine_version, int $category_id, int $user_id): void;
    public function update(Asset $asset): void;
    public function delete(string $id): void;
    public function incrementPurchasedCount(string $id): void;
    public function decrementPurchasedCount(string $id): void;
    /**
     * @return ?Asset[]
     */
    public function getAssetsByUserPurchases(int $user_id): array;
    public function getAssetsByUserReviews(int $user_id): array;
}
