<?php

namespace Controllers;

use Entities\Review;
use UseCases\Review\DeleteReviewUseCase;
use UseCases\Review\GetAllReviewsUseCase;
use UseCases\Review\GetReviewByIdUseCase;
use UseCases\Review\UpdateReviewUseCase;

class ReviewController
{
    public function __construct(
        private GetAllReviewsUseCase $getAllReviewsUseCase,
		private DeleteReviewUseCase $deleteReviewUseCase,
		private GetReviewByIdUseCase $getReviewByIdUseCase,
		private UpdateReviewUseCase $updateReviewUseCase,
    ) {}

    /**
     * @return array{reviews: Review[]}
     */
    public function getReviewsPageData(): array
    {
        $reviews = $this->getAllReviewsUseCase->execute();
        return [
            'reviews' => $reviews,
        ];
    }
    /**
     * @return array{ review: Review }
     */
    public function getReviewPageData(int $id): array
	{
		$review = $this->getReviewByIdUseCase->execute($id);
		return [
			'review' => $review,
		];
	}

	public function deleteReview(int $id): void
	{
		$this->deleteReviewUseCase->execute($id);
	}

	public function updateReview(int $id, string $title, string $review, bool $is_positive, string $positive, string $negative): void
	{
		$this->updateReviewUseCase->execute($id, $title, $review, $is_positive, $positive, $negative);
	}
}
