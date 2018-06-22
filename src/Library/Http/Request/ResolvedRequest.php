<?php

namespace Library\Http\Request;

use Library\Http\Request\InternalType\CreationType;
use Library\Http\Request\InternalType\ViewType;
use Library\Http\Request\Type\HttpTypeFactory;
use Library\Infrastructure\Notation\ArrayNotationInterface;
use Library\Infrastructure\Type\TypeInterface;
use Library\Validation\ValidatorInterface as LibraryValidator;

class ResolvedRequest implements ArrayNotationInterface, \JsonSerializable
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
     * @param RequestDataModel $requestDataModel
     * @param LibraryValidator $validator
     */
    public function __construct(
        RequestDataModel $requestDataModel,
        LibraryValidator $validator
    ) {
        $this->validate($requestDataModel, $validator);

        $this->internalType = ($requestDataModel->getInternalType() === 'view') ?
            ViewType::fromValue('view') :
            CreationType::fromValue('creation');

        $this->method = HttpTypeFactory::create($requestDataModel->getMethod());
        $this->name = $requestDataModel->getName();
        $this->requestData = new RequestData($requestDataModel->getData());
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
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'method' => $this->getMethod(),
            'internal_type' => $this->getInternalType(),
            'data' => $this->getRequestData()->getData()
        ];
    }
    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
    /**
     * @param RequestDataModel $requestDataModel
     * @param LibraryValidator $validator
     */
    private function validate(RequestDataModel $requestDataModel, LibraryValidator $validator)
    {
        $validator->validate($requestDataModel);

        if ($validator->hasErrors()) {
            throw new \RuntimeException($validator->getErrorsString());
        }
    }
}