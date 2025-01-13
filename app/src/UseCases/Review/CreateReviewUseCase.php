<?php

namespace UseCases\Review;

use Repositories\Review\ReviewRepositoryInterface;
use Services\Session\SessionService;
use Exception;
use RuntimeException;

class CreateReviewUseCase
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository,
    ) {}

    /**
     * @throws Exception
     */
    public function execute(
        string $asset_id,
		string $title,
        string $review,
        string $positive,
        string $negative,
        bool $is_positive
    ): void {
        try {
			$session = SessionService::getInstance();
			$user_id = $session->getUser()['id'];

            $this->reviewRepository->create(
                $asset_id,
                $user_id,
				$title,
                $review,
                $positive,
                $negative,
                $is_positive
            );
        } catch (RuntimeException $e) {
            throw new Exception("Cannot create review: {$e->getMessage()}");
        }
    }
}
