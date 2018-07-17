<?php

namespace Library\Http\Request\Uniformity;

use Library\Infrastructure\Type\TypeInterface;

class UniformedRequest
{
    /**
     * @var TypeInterface $internalType
     */
    private $internalType;
    /**
     * @var TypeInterface $method
     */
    private $method;
    /**
     * @var iterable $data
     */
    private $data;
    /**
     * @var string $uniqueName
     */
    private $uniqueName;
    /**
     * UniformedRequest constructor.
     * @param TypeInterface $internalType
     * @param TypeInterface $method
     * @param iterable $data
     * @param string $uniqueName
     */
    public function __construct(
        TypeInterface $internalType,
        TypeInterface $method,
        iterable $data,
        string $uniqueName
    ) {
        $this->internalType = $internalType;
        $this->method = $method;
        $this->data = $data;
        $this->uniqueName = $uniqueName;
    }

    /**
     * @return TypeInterface
     */
    public function getInternalType(): TypeInterface
    {
        return $this->internalType;
    }
    /**
     * @return TypeInterface
     */
    public function getMethod(): TypeInterface
    {
        return $this->method;
    }
    /**
     * @return iterable
     */
    public function getData(): iterable
    {
        return $this->data;
    }
    /**
     * @return string
     */
    public function getUniqueName(): string
    {
        return $this->uniqueName;
    }
}