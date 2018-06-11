<?php

namespace App\Tests\Unit;

use App\DataSourceLayer\Doctrine\Entity\Language;
use App\DataSourceLayer\RepositoryFactory;
use App\DataSourceLayer\Type\MysqlType;
use App\Tests\Library\BasicSetup;

class RepositoryFactoryTest extends BasicSetup
{
    public function test_repository_singleton()
    {
        $object1 = RepositoryFactory::create(Language::class, MysqlType::fromValue());
        $object2 = RepositoryFactory::create(Language::class, MysqlType::fromValue());
        $object3 = RepositoryFactory::create(Language::class, MysqlType::fromValue());
        $object4 = RepositoryFactory::create(Language::class, MysqlType::fromValue());

        static::assertEquals($object1, $object2);
        static::assertEquals($object2, $object3);
        static::assertEquals($object1, $object3);
        static::assertEquals($object2, $object4);
    }
}