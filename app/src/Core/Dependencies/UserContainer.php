<?php

namespace Core\Dependencies;

use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\User\UserSQLiteRepository;
use PDO;

class UserContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(UserSQLiteRepository::class, function () {
            return new UserSQLiteRepository($this->get(PDO::class));
        });
    }
}
