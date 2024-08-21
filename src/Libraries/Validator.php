<?php

namespace MiniMarkPlace\Libraries;

use MiniMarkPlace\Exceptions\ValidatorException;

class Validator
{
    private static $messages = [
        'required' => ':attribute is required.',
        'string'   => ':attribute must be a string.',
        'min'      => ':attribute must be at least :min characters.',
        'max'      => ':attribute cannot be more than :max characters.',
        'integer'  => ':attribute must be an integer.',
    ];

    public static function validate(array $data, array $rules)
    {
        $errors = [];

        foreach ($rules as $field => $ruleSet) {
            $ruleArray = explode('|', $ruleSet);

            foreach ($ruleArray as $rule) {
                $ruleName = explode(':', $rule)[0];
                $parameters = array_slice(explode(':', $rule), 1);

                switch ($ruleName) {
                    case 'required':
                        $error = self::validateRequired($field, $data[$field] ?? null);
                        break;
                    case 'string':
                        $error = self::validateString($field, $data[$field] ?? null);
                        break;
                    case 'min':
                        $error = self::validateMin($field, $data[$field] ?? null, $parameters);
                        break;
                    case 'max':
                        $error = self::validateMax($field, $data[$field] ?? null, $parameters);
                        break;
                    case 'integer':
                        $error = self::validateInteger($field, $data[$field] ?? null);
                        break;
                    default:
                        $error = null;
                }

                if ($error) {
                    $errors[$field][] = $error;
                }
            }
        }

        if (!empty($errors)) {
            throw new ValidatorException($errors);
        }

        return true;
    }

    private static function validateRequired($field, $value)
    {
        if (empty(trim($value))) {
            return str_replace(':attribute', $field, self::$messages['required']);
        }

        return null;
    }

    private static function validateString($field, $value)
    {
        if (!is_string($value)) {
            return str_replace(':attribute', $field, self::$messages['string']);
        }

        return null;
    }

    private static function validateMin($field, $value, $parameters)
    {
        $min = $parameters[0] ?? 0;
        if (strlen($value) < $min) {
            return str_replace(
                [':attribute', ':min'],
                [$field, $min],
                self::$messages['min']
            );
        }

        return null;
    }

    private static function validateMax($field, $value, $parameters)
    {
        $max = $parameters[0] ?? PHP_INT_MAX;
        if (strlen($value) > $max) {
            return str_replace(
                [':attribute', ':max'],
                [$field, $max],
                self::$messages['max']
            );
        }

        return null;
    }

    private static function validateInteger($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_INT) !== false) {
            return str_replace(':attribute', $field, self::$messages['integer']);
        }

        return null;
    }
}
