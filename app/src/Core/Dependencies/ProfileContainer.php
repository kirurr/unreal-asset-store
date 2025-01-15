<?php

namespace Core\Dependencies;

use Controllers\ProfileController;
use Core\ContainerInterface;
use Core\ServiceContainer;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetsByUserPurhcasesUseCase;
use UseCases\Asset\GetAssetsByUserReviewsUseCase;
use UseCases\User\GetUserUseCase;
use UseCases\Category\GetTrendingCategoriesUseCase;
use UseCases\Review\GetReviewByIdUseCase;
use UseCases\Review\UpdateReviewUseCase;
use UseCases\Review\DeleteReviewUseCase;

class ProfileContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(
            ProfileController::class,
            function () {
                return new ProfileController(
                    $this::get(GetUserUseCase::class),
                    $this::get(GetAllAssetUseCase::class),
                    $this::get(GetAssetsByUserPurhcasesUseCase::class),
                    $this::get(GetAssetsByUserReviewsUseCase::class),
                    $this::get(GetTrendingCategoriesUseCase::class),
                    $this::get(GetReviewByIdUseCase::class),
                    $this::get(UpdateReviewUseCase::class),
                    $this::get(DeleteReviewUseCase::class)
                );
            }
        );
    }
}
