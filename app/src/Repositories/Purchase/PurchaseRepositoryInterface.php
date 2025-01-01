<?php

namespace Repositories\Purchase;

use Entities\Purchase;

interface PurchaseRepositoryInterface
{
    public function create(string $asset_id, int $user_id): void;
    public function delete(string $id): void;
    public function getById(string $id): ?Purchase;

    /**
     * @return Purchase[]
     */
    public function getAllByAssetId(string $asset_id): array;

    /**
     * @return Purchase[]
     */
    public function getAllByUserId(int $user_id): array;

    /**
     * @return Purchase[]
     */
    public function getAll(): array;
}
