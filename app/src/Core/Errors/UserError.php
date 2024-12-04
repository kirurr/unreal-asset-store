<?php

namespace Core\Errors;

use Core\Errors\ErrorCode;

class UserError extends Error
{
    /**
     * @param array<string> $fields
     */
    public function __construct(
        string $message,
        public ErrorCode $code,
        public array $fields
    ) {
        parent::__construct($message, $code);
    }

    public function getData(): array
    {
        return ['message' => $this->message, 'code' => $this->code, 'fields' => $this->fields];
    }
}
