<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\LogicLayer\DomainModelInterface;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;

class UserGateway
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * UserGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator
    ) {
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
    }

    public function create(DomainModelInterface $domainModel): DataSourceEntity
    {

    }
}