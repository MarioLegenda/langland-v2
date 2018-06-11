<?php

namespace App\DataSourceLayer\Type;

use Library\Infrastructure\Type\StringType;
use Library\Infrastructure\Type\TypeInterface;

class MysqlType extends StringType
{
    /**
     * @var array $types
     */
    protected static $types = [
        'mysql',
    ];
    /**
     * @param mixed $value
     * @return TypeInterface
     */
    public static function fromValue($value = null): TypeInterface
    {
        return parent::fromValue('mysql');
    }
}