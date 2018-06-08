<?php

namespace App\LogicGateway\Contract;

use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\PresentationLayer\Model\PresentationModelInterface;
use Library\Infrastructure\Helper\SerializerWrapper;

abstract class Gateway
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    protected $serializerWrapper;
    /**
     * Gateway constructor.
     * @param SerializerWrapper $serializerWrapper
     */
    public function __construct(
        SerializerWrapper $serializerWrapper
    ) {
        $this->serializerWrapper = $serializerWrapper;
    }
    /**
     * @param PresentationModelInterface $model
     * @return DomainModelInterface
     */
    abstract public function create(PresentationModelInterface $model): DomainModelInterface;
}