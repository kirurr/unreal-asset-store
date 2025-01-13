<?php

namespace Repositories\Review;

use Entities\Review;

interface ReviewRepositoryInterface
{
    public function create(
		string $asset_id,
		string $user_id,
		string $title,
		string $review,
		string $positive,
		string $negative,
		bool $is_positive
	): void;
    public function delete(string $id): void;
	public function update(Review $review): void;
    public function getById(string $id): ?Review;

    /**
     * @return Review[]
     */
    public function getAllByAssetId(string $asset_id): array;

    /**
     * @return Review[]
     */
    public function getAllByUserId(string $user_id): array;

    /**
     * @return Review[]
     */
    public function getAll(): array;
}
