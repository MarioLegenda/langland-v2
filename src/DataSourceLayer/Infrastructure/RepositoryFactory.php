<?php

namespace App\DataSourceLayer\Infrastructure;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Image;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Word;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\WordCategory;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\CategoryRepository;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\ImageRepository;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\LanguageRepository;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\WordCategoryRepository;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\WordRepository;
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
     * @param string $class
     * @param TypeInterface $type
     * @return RepositoryInterface
     */
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

            case Category::class:
                $repository = new CategoryRepository(
                    $dataSource,
                    $classMetadata
                );

                $repoClass = CategoryRepository::class;

                return $this->saveAndReturnRepository($repoClass, $repository);

            case Image::class:
                $repository = new ImageRepository(
                    $dataSource,
                    $classMetadata
                );

                $repoClass = ImageRepository::class;

                return $this->saveAndReturnRepository($repoClass, $repository);

            case Word::class:
                $repository = new WordRepository(
                    $dataSource,
                    $classMetadata
                );

                $repoClass = WordRepository::class;

                return $this->saveAndReturnRepository($repoClass, $repository);

            case WordCategory::class:
                $repository = new WordCategoryRepository(
                    $dataSource,
                    $classMetadata
                );

                $repoClass = WordCategoryRepository::class;

                return $this->saveAndReturnRepository($repoClass, $repository);
            default:
                $message = sprintf(
                    'Repository for class \'%s\' could not be found',
                    $class
                );

                throw new \RuntimeException($message);
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