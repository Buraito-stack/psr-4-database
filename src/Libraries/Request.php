<?php

namespace MiniMarkPlace\Libraries;

use MiniMarkPlace\Exceptions\ValidatorException;

class Request
{
    private static string $method;
    private static string $uri;
    private static array $inputs = []; 

    public static function initialize(): void
    {
        self::$method = $_SERVER['REQUEST_METHOD'];
        self::$uri = $_SERVER['REQUEST_URI'];
        self::handleInput();
    }

    private static function handleInput(): void
    {
        self::$inputs = self::$method === 'POST'
            ? filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? []
            : filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? [];
    }

    public static function getInput(string $name): ?string
    {
        return self::$inputs[$name] ?? null;
    }

    public static function allInput(): array
    {
        return self::$inputs;
    }

    public static function getMethod(): string
    {
        return self::$method;
    }

    public static function getUri(): string
    {
        return self::$uri;
    }
}
?>
