<?php

namespace MiniMarkPlace\Libraries;

class Request
{
    private string $method;
    private string $uri;
    private array $inputs = []; 

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri    = $_SERVER['REQUEST_URI'];
        $this->handleInput();
    }

    private function handleInput(): void
    {
        $this->inputs = $this->method === 'POST'
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

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
?>
