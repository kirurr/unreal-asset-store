<?php

namespace Core\Dependencies;

use Controllers\ProfileController;
use Core\ContainerInterface;
use Core\ServiceContainer;

use Services\Session\SessionService;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetsByUserPurhcasesUseCase;
use UseCases\User\GetUserUseCase;

class ProfileContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(
            ProfileController::class, function () {
                return new ProfileController(
                    $this::get(SessionService::class),
                    $this::get(GetUserUseCase::class),
                    $this::get(GetAllAssetUseCase::class),
					$this::get(GetAssetsByUserPurhcasesUseCase::class)
                );
            }
        );

    }
}
