<?php

namespace App\DataSourceLayer;

use App\DataSourceLayer\Doctrine\Entity\Language;
use App\DataSourceLayer\Doctrine\Repository\LanguageRepository;
use App\DataSourceLayer\Type\MysqlType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Library\Infrastructure\Type\TypeInterface;

class RepositoryFactory
{
    /**
     * @var array $repositories
     */
    private $repositories = [];
    /**
     * @var RepositoryFactory $instance
     */
    private static $instance;
    /**
     * @param TypeInterface $type
     * @param string $class
     * @return RepositoryInterface
     */
    public static function create(string $class, TypeInterface $type): RepositoryInterface
    {
        static::resolveInstance();

        if ($type instanceof MysqlType) {
            return static::$instance->resolveMysqlRepository($class, $type);
        }
    }

    private function __construct() {}

    private static function resolveInstance(): void
    {
        static::$instance = (static::$instance instanceof static) ? static::$instance : new static();
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