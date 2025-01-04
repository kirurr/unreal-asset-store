<?php

namespace Core\Dependencies;

use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\Asset\AssetSQLiteRepository;
use Repositories\Category\CategorySQLiteRepository;
use Repositories\File\SQLiteFileRepository;
use Repositories\Image\SQLiteImageRepository;
use Repositories\Purchase\SQLitePurchaseRepository;
use Repositories\Review\SQLiteReviewRepository;
use Repositories\User\UserSQLiteRepository;
use PDO;

class RepositoryContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(
            SQLiteImageRepository::class, function () {
                return new SQLiteImageRepository($this::get(PDO::class));
            }
        );

        $this->set(
            AssetSQLiteRepository::class, function () {
                return new AssetSQLiteRepository($this::get(PDO::class));
            }
        );

        $this->set(SQLiteFileRepository::class, function () {
            return new SQLiteFileRepository($this::get(PDO::class));
        });

        $this->set(
            UserSQLiteRepository::class, function () {
                return new UserSQLiteRepository($this::get(PDO::class));
            }
        );

        $this->set(
            CategorySQLiteRepository::class, function () {
                return new CategorySQLiteRepository($this::get(PDO::class));
            }
        );

        $this->set(SQLiteReviewRepository::class, function () {
            return new SQLiteReviewRepository(
                $this->get(PDO::class),
            );
        });
        $this->set(SQLitePurchaseRepository::class, function () {
            return new SQLitePurchaseRepository($this::get(PDO::class));
        });
    }
}
