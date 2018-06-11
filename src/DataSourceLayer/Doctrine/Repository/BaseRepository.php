<?php

namespace App\DataSourceLayer\Doctrine\Repository;

use App\DataSourceLayer\RepositoryInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\LazyCriteriaCollection;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\QueryBuilder;

class BaseRepository implements RepositoryInterface
{
    /**
     * @var string
     */
    protected $_entityName;

    /**
     * @var EntityManager
     */
    protected $_em;

    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    protected $_class;
    /**
     * BaseRepository constructor.
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata $class
     */
    public function __construct(
        EntityManagerInterface $em,
        Mapping\ClassMetadata $class
    ) {
        $this->_entityName = $class->name;
        $this->_em         = $em;
        $this->_class      = $class;
    }
    /**
     * @param string $alias
     * @param null|string $indexBy
     * @return QueryBuilder
     */
    public function createQueryBuilder(string $alias, string $indexBy = null)
    {
        return $this->_em->createQueryBuilder()
            ->select($alias)
            ->from($this->_entityName, $alias, $indexBy);
    }
    /**
     * @param string $alias
     * @return ResultSetMappingBuilder
     */
    public function createResultSetMappingBuilder(string $alias)
    {
        $rsm = new ResultSetMappingBuilder($this->_em, ResultSetMappingBuilder::COLUMN_RENAMING_INCREMENT);
        $rsm->addRootEntityFromClassMetadata($this->_entityName, $alias);

        return $rsm;
    }
    /**
     * @param string $queryName
     * @return Query
     * @throws Mapping\MappingException
     */
    public function createNamedQuery(string $queryName)
    {
        return $this->_em->createQuery($this->_class->getNamedQuery($queryName));
    }
    /**
     * @param string $queryName
     * @return NativeQuery
     * @throws Mapping\MappingException
     */
    public function createNativeNamedQuery(string $queryName)
    {
        $queryMapping   = $this->_class->getNamedNativeQuery($queryName);
        $rsm            = new Query\ResultSetMappingBuilder($this->_em);
        $rsm->addNamedNativeQueryMapping($this->_class, $queryMapping);

        return $this->_em->createNativeQuery($queryMapping['query'], $rsm);
    }
    /**
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     */
    public function clear()
    {
        $this->_em->clear($this->_class->rootEntityName);
    }
    /**
     * @param int $id
     * @param null|int $lockMode
     * @param int|null $lockVersion
     * @return array|null|object
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function find($id, int $lockMode = null, int $lockVersion = null)
    {
        return $this->_em->find($this->_entityName, $id, $lockMode, $lockVersion);
    }
    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->findBy([]);
    }
    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null|int $limit
     * @param null|int $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null)
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);

        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
    }
    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return array|null|object
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);

        return $persister->load($criteria, null, null, [], null, 1, $orderBy);
    }
    /**
     * @param array $criteria
     * @return int
     */
    public function count(array $criteria)
    {
        return $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName)->count($criteria);
    }
    /**
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws ORMException
     */
    public function __call($method, $arguments)
    {
        if (0 === strpos($method, 'findBy')) {
            return $this->resolveMagicCall('findBy', substr($method, 6), $arguments);
        }

        if (0 === strpos($method, 'findOneBy')) {
            return $this->resolveMagicCall('findOneBy', substr($method, 9), $arguments);
        }

        if (0 === strpos($method, 'countBy')) {
            return $this->resolveMagicCall('count', substr($method, 7), $arguments);
        }

        throw new \BadMethodCallException(
            "Undefined method '$method'. The method name must start with ".
            "either findBy, findOneBy or countBy!"
        );
    }
    /**
     * @param object $object
     * @throws ORMException
     */
    public function markToBeSaved(object $object): void
    {
        $this->_em->persist($object);
    }
    /**
     * @param object|null $object
     * @throws ORMException
     */
    public function save(object $object = null): void
    {
        if (!is_object($object)) {
            $message = sprintf(
                'Cannot save a non object'
            );

            throw new \RuntimeException($message);
        }

        $this->_em->persist($object);
        $this->_em->flush();
    }
    /**
     * @return string
     */
    protected function getEntityName(): string
    {
        return $this->_entityName;
    }
    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->getEntityName();
    }
    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->_em;
    }
    /**
     * @return Mapping\ClassMetadata
     */
    protected function getClassMetadata(): Mapping\ClassMetadata
    {
        return $this->_class;
    }
    /**
     * @param Criteria $criteria
     * @return LazyCriteriaCollection
     */
    public function matching(Criteria $criteria): LazyCriteriaCollection
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);

        return new LazyCriteriaCollection($persister, $criteria);
    }
    /**
     * @param $method
     * @param $by
     * @param array $arguments
     * @return mixed
     * @throws ORMException
     */
    private function resolveMagicCall($method, $by, array $arguments)
    {
        if (! $arguments) {
            throw ORMException::findByRequiresParameter($method . $by);
        }

        $fieldName = lcfirst(Inflector::classify($by));

        if (! ($this->_class->hasField($fieldName) || $this->_class->hasAssociation($fieldName))) {
            throw ORMException::invalidMagicCall($this->_entityName, $fieldName, $method . $by);
        }

        return $this->$method([$fieldName => $arguments[0]], ...array_slice($arguments, 1));
    }
}