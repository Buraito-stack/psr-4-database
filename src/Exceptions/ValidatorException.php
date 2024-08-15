<?php

namespace MiniMarkPlace\Exceptions;

class ValidatorException extends \Exception
{
    private array $validationErrors;

    public function __construct(
        string $message = "Validation failed",
        int $code = 0,
        \Throwable $previous = null,
        array $validationErrors = []
    ) {
        parent::__construct($message, $code, $previous);
        $this->validationErrors = $validationErrors;
    }

    /**
     * Get validation errors.
     *
     * @return array
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    /**
     * Format errors as a string.
     *
     * @return string
     */
    public function formatErrors(): string
    {
        $errors = [];
        foreach ($this->validationErrors as $field => $messages) {
            foreach ($messages as $message) {
                $errors[] = $message;
            }
        }
        return implode(', ', $errors);
    }
}
?>
