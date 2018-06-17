<?php

namespace App\Infrastructure\Model;

use Library\Infrastructure\Type\TypeInterface;

class CollectionMetadata
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var TypeInterface $action
     */
    private $action;
    /**
     * CategoryMetadata constructor.
     * @param int $id
     * @param TypeInterface $action
     */
    public function __construct(
        int $id,
        TypeInterface $action
    ) {
        $this->id = $id;
        $this->action = $action;
    }
    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return TypeInterface
     */
    public function getAction(): TypeInterface
    {
        return $this->action;
    }
    /**
     * @param TypeInterface $action
     */
    public function setAction(TypeInterface $action): void
    {
        $this->action = $action;
    }
}