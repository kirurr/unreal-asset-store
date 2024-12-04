<?php

namespace Core\Dependencies;

use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\User\SQLiteUserRepository;

class UserContainer extends ServiceContainer implements  ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set('SQLiteUserRepository', function () {
            return new SQLiteUserRepository($this->get('PDO'));
        });
    }
}
