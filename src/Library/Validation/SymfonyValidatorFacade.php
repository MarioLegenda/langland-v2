<?php

namespace Library\Validation;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidator;

class SymfonyValidatorFacade implements ValidatorInterface
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
     * SymfonyValidatorFacade constructor.
     * @param SymfonyValidator $validator
     */
    public function __construct(SymfonyValidator $validator)
    {
        $this->validator = $validator;
    }
    /**
     * @param mixed $value
     * @param array $additionalData
     */
    public function validate($value, array $additionalData = [])
    {
        $this->validator->validate($value, $constraints, $groups);

        $errors = $this->validator->validate($value);

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
     * @return array
     */
    public function getErrorsArray(): ?array
    {
        return $this->errorsArray;
    }
    /**
     * @return SymfonyValidator
     */
    public function getInternalValidator()
    {
        return $this->validator;
    }
}