<?php

namespace Services\Validation;

class CategoryValidationService
{
    /**
     * @return array{ 0: array<string, string>, 1: array{ name: string, description: string } }
     */
    public function validate(string $name, string $description): array
    {
        $vname = htmlspecialchars(trim($name));
        $vdescription = htmlspecialchars(trim($description));

        $errors = [];
        if (empty($vname)) {
            $errors['name'] = 'Name is required';
        }
        if (empty($vdescription)) {
            $errors['description'] = 'Description is required';
        }
        return [$errors, ['name' => $vname, 'description' => $vdescription]];
    }
}
