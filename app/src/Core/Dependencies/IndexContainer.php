<?php

namespace Core\Dependencies;

use Controllers\MainPageController;
use Core\ContainerInterface;
use Core\ServiceContainer;
use Services\PasswordHasher\PasswordHasherService;
use Services\Session\SessionService;
use Exception;
use PDO;

class IndexContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        try {
            $this->set(PDO::class, function () {
                $dbPath = '/var/www/storage/test.db';
                $pdo = new PDO('sqlite:' . $dbPath);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }

        $this->set(SessionService::class, function () {
            return new SessionService();
        });

        $this->set(MainPageController::class, function () {
            return new MainPageController($this->get(SessionService::class));
        });

        $this->set(PasswordHasherService::class, function () {
            return new PasswordHasherService();
        });
    }
}
