<?php

namespace Services\Validation;

class ReviewValidationService
{
    /**
     * @return array{ 1: errors: array{ review: string }, 2: data: array{ review: string, is_positive: bool, positive: string, negative: string } }
     */
    public function validate(
        string $review,
        bool $is_positive,
        string $positive,
        string $negative
    ): array {
        $vreview = htmlspecialchars(trim($review));
        $vis_positive = boolval(htmlspecialchars($is_positive));
        $vpositive = htmlspecialchars(trim($positive));
        $vnegative = htmlspecialchars(trim($negative));

        $errors = [];
        if (empty($review)) {
            $errors['review'] = 'Review cannot be empty';
        }

        return [$errors, [
            'review' => $vreview,
            'is_positive' => $vis_positive,
            'positive' => $vpositive,
            'negative' => $vnegative
        ]];
    }
}
