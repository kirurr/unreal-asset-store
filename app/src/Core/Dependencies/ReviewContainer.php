<?php

namespace Core\Dependencies;

use Controllers\ReviewController;
use Core\ContainerInterface;
use Core\ServiceContainer;
use Repositories\Review\SQLiteReviewRepository;
use Services\Validation\ReviewValidationService;
use UseCases\Review\CreateReviewUseCase;
use UseCases\Review\DeleteReviewUseCase;
use UseCases\Review\GetAllReviewsUseCase;
use UseCases\Review\GetReviewByIdUseCase;
use UseCases\Review\GetReviewsByAssetIdUseCase;
use UseCases\Review\GetReviewsByUserIdUseCase;
use UseCases\Review\UpdateReviewUseCase;

class ReviewContainer extends ServiceContainer implements ContainerInterface
{
    public function initDependencies(): void
    {
        $this->set(GetAllReviewsUseCase::class, function () {
            return new GetAllReviewsUseCase(
                $this::get(SQLiteReviewRepository::class)
            );
        });

        $this->set(GetReviewsByAssetIdUseCase::class, function () {
            return new GetReviewsByAssetIdUseCase(
                $this::get(SQLiteReviewRepository::class)
            );
        });

        $this->set(DeleteReviewUseCase::class, function () {
            return new DeleteReviewUseCase(
                $this::get(SQLiteReviewRepository::class),
            );
        });

        $this->set(CreateReviewUseCase::class, function () {
            return new CreateReviewUseCase(
                $this::get(SQLiteReviewRepository::class),
            );
        });

        $this->set(UpdateReviewUseCase::class, function () {
            return new UpdateReviewUseCase(
                $this::get(SQLiteReviewRepository::class),
            );
        });
		$this->set(GetReviewByIdUseCase::class, function () {
			return new GetReviewByIdUseCase(
				$this::get(SQLiteReviewRepository::class)
			);
		});

		$this->set(GetReviewsByUserIdUseCase::class, function () {
			return new GetReviewsByUserIdUseCase(
				$this::get(SQLiteReviewRepository::class)
			);
		});

		$this->set(ReviewValidationService::class, function () {
			return new ReviewValidationService();
		});

        $this->set(ReviewController::class, function () {
            return new ReviewController(
                $this::get(GetAllReviewsUseCase::class),
                $this::get(DeleteReviewUseCase::class),
				$this::get(GetReviewByIdUseCase::class),
				$this::get(UpdateReviewUseCase::class),
            );
        });
    }
}
