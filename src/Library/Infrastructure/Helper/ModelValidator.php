<?php

namespace Library\Infrastructure\Helper;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidator;
use Library\Validation\ValidatorInterface as LibraryValidator;

class ModelValidator implements LibraryValidator
{
    /**
     * @var array $errorsArray
     */
    private $errorsArray;
    /**
     * @var string $errorsString
     */
    private $errorsString;
    /**
     * @var SymfonyValidator $validator
     */
    private $validator;
    /**
     * ModelValidator constructor.
     * @param SymfonyValidator $validator
     */
    public function __construct(SymfonyValidator $validator)
    {
        $this->validator = $validator;
    }
    /**
     * @param array $additionalData
     * @param object|array $value
     */
    public function tryValidate($value, array $additionalData = [])
    {
        $this->validateParameters($value);

        $constraints = (isset($additionalData['constraints'])) ? $additionalData['constraints'] : null;
        $groups = (isset($additionalData['groups'])) ? $additionalData['groups'] : null;

        $errors = $this->validator->validate($value, $constraints, $groups);

        $errorsArray = [];
        $errorsString = null;
        if (count($errors) > 0) {
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()] = $error->getMessage();
            }

            $errorsString = (string) $errors;
        }

        $this->errorsArray = $errorsArray;
        $this->errorsString = $errorsString;
    }
    /**
     * @param object|array $value
     * @param array $additionalData
     * @throws \RuntimeException
     */
    public function validate($value, array $additionalData = [])
    {
        $this->validateParameters($value);

        $this->tryValidate($value);

        if ($this->hasErrors()) {
            throw new \RuntimeException($this->getErrorsString());
        }
    }
    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errorsString) or !empty($this->errorsArray);
    }
    /**
     * @return string
     */
    public function getErrorsString(): ?string
    {
        return $this->errorsString;
    }
    /**
     * @return string
     */
    public function getUserFriendlyErrorsString(): string
    {
        $userFriendlyErrorString = '';

        foreach ($this->errorsArray as $error) {
            $userFriendlyErrorString.=$error."\r\n";
        }

        return $userFriendlyErrorString;
    }
    /**
     * @return array
     */
    public function getErrorsArray(): ?array
    {
        return $this->errorsArray;
    }
    /**
     * @param $value
     * @throws \RuntimeException
     */
    private function validateParameters($value)
    {
        if (!is_object($value) and !is_array($value)) {
            $message = sprintf(
                'Invalid validation value given. Validation value has to be an object or array, \'%s\' given',
                gettype($value)
            );

            throw new \RuntimeException($message);
        }
    }
}