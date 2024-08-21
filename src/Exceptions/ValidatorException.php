<?php

namespace MiniMarkPlace\Exceptions;

class ValidatorException extends \Exception
{
    private array $errors;

    public function __construct(
        array $errors = [],
        string $message = "Validation failed",
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * Get validation errors.
     *
     * @return array
     */
    public function getValidationErrors(): array
    {
        return $this->errors;
    }

    /**
     * Format errors as a JSON string.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode([
            'message' => $this->getMessage(),
            'errors' => $this->getValidationErrors()
        ]);
    }
}
