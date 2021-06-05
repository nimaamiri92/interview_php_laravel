<?php


namespace App\Tools;


use Illuminate\Validation\ValidationException;

class CustomValidationError
{
    private $errors = [];

    public  function setError(string $field, $fieldError)
    {
        if (is_array($fieldError)) {
            foreach ($fieldError as $key => $error) {
                $this->errors[$key][$field] = $error;
            }
        } else {
            $this->errors[$field] = [$fieldError];
        }


        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function throwErrors()
    {
        $error = ValidationException::withMessages($this->getErrors());
        throw $error;
    }
}