<?php

namespace Library\Http\Request\Type;

use Library\Infrastructure\Type\TypeInterface;

class HttpTypeFactory
{
    /**
     * @param string $type
     * @return TypeInterface
     */
    public static function create(?string $type): TypeInterface
    {
        $types = [
            'get' => GetHttpType::class,
            'post' => PostHttpType::class,
            'patch' => PatchHttpType::class,
            'put' => PutHttpType::class,
        ];

        if (!array_key_exists(strtolower($type), $types)) {
            $message = sprintf(
                'Cannot create http type. Invalid type \'%s\' given',
                $type
            );

            throw new \RuntimeException($message);
        }

        return $types[$type]::{'fromValue'}($type);
    }
}