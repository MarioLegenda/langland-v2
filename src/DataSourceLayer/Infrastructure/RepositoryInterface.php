<?php

namespace App\DataSourceLayer\Infrastructure;

interface RepositoryInterface
{
    /**
     * @param int $id
     * @return array|object
     */
    public function find(int $id);
    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function findBy(
        array $criteria,
        array $orderBy = null,
        int $limit = null,
        int $offset = null
    );
    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return array|object
     */
    public function findOneBy(array $criteria, array $orderBy = null);
    /**
     * @return array
     */
    public function findAll(): array;
    /**
     * @param object $object
     */
    public function markToBeSaved(object $object): void;
    /**
     * @param object|null $object
     * @void
     */
    public function save(object $object = null): void;
}