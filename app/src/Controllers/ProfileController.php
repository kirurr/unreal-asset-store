<?php

namespace Controllers;

use Services\Session\SessionService;
use UseCases\Asset\GetAllAssetUseCase;
use UseCases\Asset\GetAssetsByUserPurhcasesUseCase;
use UseCases\Asset\GetAssetsByUserReviewsUseCase;
use UseCases\Category\GetTrendingCategoriesUseCase;
use UseCases\Review\GetReviewByIdUseCase;
use UseCases\Review\UpdateReviewUseCase;
use UseCases\User\GetUserUseCase;
use UseCases\Review\DeleteReviewUseCase;

class ProfileController
{
    public function __construct(
        private GetUserUseCase $getUserUseCase,
        private GetAllAssetUseCase $getAllAssetUseCase,
        private GetAssetsByUserPurhcasesUseCase $getAssetsByUserPurhcasesUseCase,
        private GetAssetsByUserReviewsUseCase $getAssetsByUserReviewsUseCase,
        private GetTrendingCategoriesUseCase $getTrendingCategoriesUseCase,
        private GetReviewByIdUseCase $getReviewByIdUseCase,
        private UpdateReviewUseCase $updateReviewUseCase,
        private DeleteReviewUseCase $deleteReviewUseCase
    ) {}

    /**
     * @return array{ user: User, assets: Asset[], purchased_assets: Asset[], reviews: array{ 1: Asset, 2: Review }[], trendingCategories: Category[] }
     */
    public function getProfileData(string $type): array
    {
        $session = SessionService::getInstance();
        $sessionUser = $session->getUser();

        $user = $this->getUserUseCase->execute((int) $sessionUser['id']);

        switch ($type) {
            case 'created':
                $assets = $this->getAllAssetUseCase->execute(user_id: $user->id);
                break;
            case 'purchased':
                $assets = $this->getAssetsByUserPurhcasesUseCase->execute($user->id);
                break;
            default:
                $assets = $this->getAllAssetUseCase->execute(user_id: $user->id);
                break;
        }
        $reviews = $this->getAssetsByUserReviewsUseCase->execute($user->id);

        return [
            'user' => $user,
            'assets' => $assets,
            'reviews' => $reviews,
            'trendingCategories' => $this->getTrendingCategoriesUseCase->execute(),
        ];
    }

    /** @return array{ review: Review } */
    public function getReviewEditPageData(int $id): array
    {
        return [
            'trendingCategories' => $this->getTrendingCategoriesUseCase->execute(),
            'review' => $this->getReviewByIdUseCase->execute($id)
        ];
    }

    public function updateReview(int $id, string $title, string $review, string $positive, string $negative, bool $is_positive): void
    {
        $this->updateReviewUseCase->execute($id, $title, $review, $is_positive, $positive, $negative);
    }

    public function deleteReview(int $id): void
    {
        $this->deleteReviewUseCase->execute($id);
    }
}
