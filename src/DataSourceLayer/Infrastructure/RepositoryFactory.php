<?php

namespace App\DataSourceLayer\Infrastructure;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\LanguageRepository;
use App\DataSourceLayer\Infrastructure\Type\MysqlType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Library\Infrastructure\Type\TypeInterface;

class RepositoryFactory
{
    /**
     * @var array $repositories
     */
    private $repositories = [];

    public function create(string $class, TypeInterface $type)
    {
        if ($type instanceof MysqlType) {
            return $this->resolveMysqlRepository($class, $type);
        }
    }
    /**
     * @param string $class
     * @param TypeInterface $type
     * @return RepositoryInterface
     */
    private function resolveMysqlRepository(string $class, TypeInterface $type): RepositoryInterface
    {
        $classMetadata = new ClassMetadata($class);
        /** @var EntityManagerInterface $dataSource */
        $dataSource = DataSourceSetup::inst()
            ->getDataSource((string) $type)
            ->getSource();

        switch ($class) {
            case Language::class:
                $repository = new LanguageRepository(
                    $dataSource,
                    $classMetadata
                );

                $repoClass = LanguageRepository::class;

                return $this->saveAndReturnRepository($repoClass, $repository);
        }
    }
    /**
     * @param string $key
     * @param RepositoryInterface $repository
     * @return RepositoryInterface
     */
    private function saveAndReturnRepository(string $key, RepositoryInterface $repository)
    {
        if (!array_key_exists($key, $this->repositories)) {
            $this->repositories[$key] = $repository;
        }

        return $this->repositories[$key];
    }
}