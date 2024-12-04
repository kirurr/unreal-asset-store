<?php

namespace Core\Dependencies;

use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\User\SQLiteUserRepository;
use PDO;

class UserContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(SQLiteUserRepository::class, function () {
            return new SQLiteUserRepository($this->get(PDO::class));
        });
    }
}
