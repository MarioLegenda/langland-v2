<?php

namespace App\LogicLayer\Security\Model;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\Security\Domain\User as UserDomainModel;
use Library\Util\Util;

class User implements LayerPropagationResourceResponse
{
    /**
     * @var UserDomainModel $user
     */
    private $user;
    /**
     * User constructor.
     * @param UserDomainModel $user
     */
    public function __construct(UserDomainModel $user)
    {
        $this->user = $user;
    }
    /**
     * @return object|UserDomainModel
     */
    public function getPropagationObject(): object
    {
        return $this->user;
    }
    /**
     * @inheritdoc
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->user->getId(),
            'name' => $this->user->getName(),
            'lastname' => $this->user->getLastname(),
            'username' => $this->user->getUsername(),
            'email' => $this->user->getEmail(),
            'enabled' => $this->user->isEnabled(),
            'createdAt' => Util::formatFromDate($this->user->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->user->getUpdatedAt()),
        ];
    }
}