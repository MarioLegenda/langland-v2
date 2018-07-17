<?php

namespace Library\Http\Request\Uniformity;

use Library\Http\Request\Type\InternalTypeType;
use Library\Http\Request\Type\HttpTypeFactory;

class UniformRequestResolverFactory
{
    /**
     * @param array $data
     * @return UniformedRequest
     */
    public static function create(array $data): UniformedRequest
    {
        $internalType = InternalTypeType::fromValue($data['internal_type']);
        $method = HttpTypeFactory::create($data['method']);
        $requestData = $data['data'];
        $name = $data['name'];

        return new UniformedRequest(
            $internalType,
            $method,
            $requestData,
            $name
        );
    }
}