<?php

namespace MiniMarkPlace\Libraries;

use MiniMarkPlace\Exceptions\ValidatorException;

class Validator
{
    /**
     * Validate data who against rules.
     *
     * @param array $data
     * @param array $rules
     * @return void
     * @throws ValidatorException
     */
    public function validate(array $data, array $rules): void
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
