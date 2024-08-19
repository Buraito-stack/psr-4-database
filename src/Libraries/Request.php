<?php

namespace MiniMarkPlace\Libraries;

use MiniMarkPlace\Exceptions\ValidatorException;

class Request
{
    protected string $method;
    protected string $uri;
    protected array $inputs = []; 

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
}    
?>
