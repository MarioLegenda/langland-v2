<?php

namespace Library\Http\Request;

use Library\Http\Request\InternalType\CreationType;
use Library\Http\Request\InternalType\ViewType;
use Library\Http\Request\Type\HttpTypeFactory;
use Library\Infrastructure\Type\TypeInterface;
use Library\Validation\SymfonyValidatorFacade;
use Library\Validation\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ResolvedRequest
{
    /**
     * @var RequestData $requestData
     */
    private $requestData;
    /**
     * @var TypeInterface $internalType
     */
    private $internalType;
    /**
     * @var string $method
     */
    private $method;
    /**
     * @var string $name
     */
    private $name;
    /**
     * ResolvedRequest constructor.
     * @param array $requestData
     * @param ValidatorInterface|SymfonyValidatorFacade $validator
     */
    public function __construct(
        array $requestData,
        ValidatorInterface $validator
    ) {
        $this->validate($requestData, $validator);

        $this->internalType = ($requestData['internal_type'] === 'view') ?
            ViewType::fromValue('view') :
            CreationType::fromValue('creation');

        $this->method = HttpTypeFactory::create($requestData['method']);
        $this->name = $requestData['name'];
    }
    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @return RequestData
     */
    public function getRequestData(): RequestData
    {
        return $this->requestData;
    }
    /**
     * @return TypeInterface
     */
    public function getInternalType(): TypeInterface
    {
        return $this->internalType;
    }
    /**
     * @return array
     */
    public function getMethodList(): array
    {
        return [
            'get',
            'post',
            'put',
            'patch',
        ];
    }
    /**
     * @return array
     */
    public function getInternalTypeList(): array
    {
        return [
            'view',
            'creation',
        ];
    }
    /**
     * @param array $requestData
     * @param SymfonyValidatorFacade $validator
     */
    private function validate(array $requestData, SymfonyValidatorFacade $validator)
    {
        $validator->validate($requestData, [
            'constraints' => $this->getConstraints(),
        ]);

        if ($validator->hasErrors()) {
            throw new \RuntimeException($validator->getErrorsString());
        }
    }
    /**
     * @return Assert\Collection
     */
    private function getConstraints(): Assert\Collection
    {
        return new Assert\Collection(array(
            'method' => new Assert\Choice([
                'choices' => $this->getMethodList(),
                'message' => sprintf(
                    '\'method\' has to be one of %s',
                    implode(', ', $this->getMethodList())
                ),
            ]),
            'name' => new Assert\NotBlank([
                'message' => '\'name\' cannot be blank',
            ]),
            'internal_type' => new Assert\Choice([
                'choices' => $this->getInternalTypeList(),
                'message' => sprintf(
                    '\'internal_type\' has to be one of %s',
                    implode(', ', $this->getInternalTypeList())
                ),
            ]),
            'data' => new Assert\Collection([
                new Assert\Type([
                    'array',
                    'message' => '\'data\' has to be of type array'
                ]),
                new Assert\NotBlank([
                    'message' => '\'data\' cannot be blank'
                ]),
            ]),
        ));
    }
}