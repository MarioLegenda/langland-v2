<?php

namespace App\PresentationLayer\Security\EntryPoint;

use App\LogicGateway\Gateway\UserGateway;
use App\PresentationLayer\Infrastructure\Model\User;
use App\Symfony\ApiResponseWrapper;
use Symfony\Component\HttpFoundation\Response;

class UserEntryPoint
{
    /**
     * @var UserGateway $userGateway
     */
    private $userGateway;
    /**
     * @var ApiResponseWrapper $apiResponseWrapper
     */
    private $apiResponseWrapper;
    /**
     * UserEntryPoint constructor.
     * @param UserGateway $userGateway
     * @param ApiResponseWrapper $apiResponseWrapper
     */
    public function __construct(
        UserGateway $userGateway,
        ApiResponseWrapper $apiResponseWrapper
    ) {
        $this->apiResponseWrapper = $apiResponseWrapper;
        $this->userGateway = $userGateway;
    }
    /**
     * @param User $user
     * @return Response
     */
    public function create(User $user): Response
    {
        $this->userGateway->create($user);
    }
}