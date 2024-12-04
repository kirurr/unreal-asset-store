<?php

namespace Core\Errors;

enum ErrorCode: string
{
    case USER_NOT_FOUND = 'USER_NOT_FOUND';
    case USER_ALREADY_EXISTS = 'USER_ALREADY_EXISTS';
    case INVALID_CREDENTIALS = 'INVALID_CREDENTIALS';
}

class Error
{
    public function __construct(
        public string $message,
        public ErrorCode $code
    ) {}

    public function getData(): array
    {
        return ['message' => $this->message, 'code' => $this->code];
    }
}
