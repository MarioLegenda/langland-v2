<?php

namespace App\PresentationLayer\Security\EntryPoint;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
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
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(User $user): Response
    {
        /** @var LayerPropagationResourceResponse $presentationModel */
        $presentationModel = $this->userGateway->create($user);

        return $this->apiResponseWrapper->createUserCreate($presentationModel->toArray());
    }
}