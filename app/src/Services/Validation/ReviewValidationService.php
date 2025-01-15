<?php

namespace Services\Validation;

class ReviewValidationService
{
    /**
     * @return array{ 1: errors: array{ review: string }, 2: data: array{ title: string, review: string, is_positive: bool, positive: string, negative: string } }
     */
    public function validate(
		string $title,
        string $review,
        bool $is_positive,
        string $positive,
        string $negative
    ): array {
		$vtitle = htmlspecialchars(trim($title));
        $vreview = htmlspecialchars(trim($review));
        $vis_positive = boolval(htmlspecialchars($is_positive));
        $vpositive = htmlspecialchars(trim($positive));
        $vnegative = htmlspecialchars(trim($negative));

        $errors = [];
        if (empty($title)) {
            $errors['title'] = 'Title cannot be empty';
        }

        if (empty($review)) {
            $errors['review'] = 'Review cannot be empty';
        }

        return [$errors, [
			'title' => $vtitle,
            'review' => $vreview,
            'is_positive' => $vis_positive,
            'positive' => $vpositive,
            'negative' => $vnegative
        ]];
    }
}
