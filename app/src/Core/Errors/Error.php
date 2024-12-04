<?php

namespace Core\Errors;

enum ErrorCode: string
{
    case USER_NOT_FOUND = 'USER_NOT_FOUND';
    case USER_ALREADY_EXISTS = 'USER_ALREADY_EXISTS';
    case INVALID_CREDENTIALS = 'INVALID_CREDENTIALS';
    case VALIDATION_ERROR = 'VALIDATION_ERROR';
    case INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';
    case NOT_AUTHORIZED = 'NOT_AUTHORIZED';
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
