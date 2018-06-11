<?php

namespace App\DataSourceLayer;

use App\DataSourceLayer\Doctrine\Entity\Language;
use App\DataSourceLayer\Doctrine\Repository\LanguageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

class RepositoryFactory
{
    /**
     * @param string $type
     * @param string $class
     * @return RepositoryInterface
     */
    public static function create(string $class, string $type = 'mysql'): RepositoryInterface
    {
        $classMetadata = new ClassMetadata($class);
        /** @var EntityManagerInterface $dataSource */
        $dataSource = DataSourceSetup::inst()
            ->getDataSource($type)
            ->getSource();

        switch ($class) {
            case Language::class:
                return new LanguageRepository(
                    $dataSource,
                    $classMetadata
                );
        }
    }
}