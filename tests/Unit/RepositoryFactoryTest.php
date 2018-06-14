<?php

namespace App\Tests\Unit;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\RepositoryFactory;
use App\DataSourceLayer\Infrastructure\Type\MysqlType;
use App\Tests\Library\BasicSetup;

class RepositoryFactoryTest extends BasicSetup
{
    public function test_repository_singleton()
    {
        $repositoryFactory = static::$container->get(RepositoryFactory::class);

        $object1 = $repositoryFactory->create(Language::class, MysqlType::fromValue());
        $object2 = $repositoryFactory->create(Language::class, MysqlType::fromValue());
        $object3 = $repositoryFactory->create(Language::class, MysqlType::fromValue());
        $object4 = $repositoryFactory->create(Language::class, MysqlType::fromValue());

        static::assertEquals($object1, $object2);
        static::assertEquals($object2, $object3);
        static::assertEquals($object1, $object3);
        static::assertEquals($object2, $object4);
    }
}