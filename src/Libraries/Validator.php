<?php

namespace MiniMarkPlace\Libraries;

use MiniMarkPlace\Exceptions\ValidatorException;

class Validator
{
    private static $messages = [
        'required' => ':attribute diperlukan.',
        'string'   => ':attribute harus berupa string.',
        'min'      => ':attribute harus memiliki minimal :min karakter.',
        'max'      => ':attribute tidak boleh lebih dari :max karakter.',
        'integer'  => ':attribute harus berupa integer.',
    ];

    public static function validate(array $data, array $rules)
    {
        $errors = [];

        foreach ($rules as $field => $ruleSet) {
            $rulesArray = explode('|', $ruleSet);

            foreach ($rulesArray as $rule) {
                $value = $data[$field] ?? null;
                $ruleName = explode(':', $rule)[0];
                $parameters = explode(':', $rule);

                if (method_exists(static::class, $ruleName)) {
                    $error = static::$ruleName($field, $value, $parameters);

                    if ($error) {
                        $errors[$field][] = $error;
                    }
                }
            }
        }

        if (!empty($errors)) {
            throw new ValidatorException($errors);
        }

        return true;
    }

    protected static function required($field, $value, $parameters)
    {
        if (is_null($value) || $value === '') {
            return str_replace(':attribute', $field, self::$messages['required']);
        }

        return null;
    }

    protected static function string($field, $value, $parameters)
    {
        if (!is_string($value)) {
            return str_replace(':attribute', $field, self::$messages['string']);
        }

        return null;
    }

    protected static function min($field, $value, $parameters)
    {
        $min = $parameters[1] ?? 0;
        if (strlen($value) < $min) {
            return str_replace(
                [':attribute', ':min'],
                [$field, $min],
                self::$messages['min']
            );
        }

        return null;
    }

    protected static function max($field, $value, $parameters)
    {
        $max = $parameters[1] ?? PHP_INT_MAX;
        if (strlen($value) > $max) {
            return str_replace(
                [':attribute', ':max'],
                [$field, $max],
                self::$messages['max']
            );
        }

        return null;
    }

    protected static function integer($field, $value, $parameters)
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            return str_replace(':attribute', $field, self::$messages['integer']);
        }

        return null;
    }
}
