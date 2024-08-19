<?php

namespace MiniMarkPlace\Libraries;

use MiniMarkPlace\Exceptions\ValidatorException;

class Request
{
    protected string $method;
    protected string $uri;
    protected array $inputs = []; // Initialize as an empty array

    public function __construct()
    {
        $this->setMethod($_SERVER['REQUEST_METHOD']);
        $this->setUri($_SERVER['REQUEST_URI']);
        $this->handleInput();
    }

    private function handleInput(): void
    {
        $this->inputs = $this->getMethod() === 'POST'
            ? filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? []
            : filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? [];
    }

    public function getInput(string $name): ?string
    {
        return $this->inputs[$name] ?? null;
    }

    public function allInput(): array
    {
        return $this->inputs;
    }

    private function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    private function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function validate(array $data, array $rules)
    {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);
            foreach ($rulesArray as $r) {
                [$ruleName, $param] = explode(':', $r) + [null, null];
    
                switch ($ruleName) {
                    case 'required':
                        if (empty(trim($data[$field] ?? ''))) {
                            $errors[$field][] = "The $field field is required.";
                        }
                        break;
    
                    case 'string':
                        if (!is_string($data[$field]) || empty(trim($data[$field]))) {
                            $errors[$field][] = "The $field must be a valid string.";
                        }
                        break;
                        
                    case 'min':
                        $min = $param ?? 3;
                        if (strlen($data[$field]) < $min) {
                            $errors[$field][] = "The $field must be at least $min characters.";
                        }
                        break;
    
                    case 'max':
                        $max = $param ?? 25;
                        if (strlen($data[$field]) > $max) {
                            $errors[$field][] = "The $field must not be greater than $max characters.";
                        }
                        break;
    
                    case 'integer':
                        if (!filter_var($data[$field], FILTER_VALIDATE_INT)) {
                            $errors[$field][] = "The $field must be an integer.";
                        }
                        break;
                }
            }
        }
    
        if ($errors) {
            throw new ValidatorException("Validation failed", 0, null, $errors);
        }
    }
}    
?>
