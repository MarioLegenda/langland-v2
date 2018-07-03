<?php

namespace App\Web\Security;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\PresentationLayer\Infrastructure\Model\User;
use App\PresentationLayer\Security\EntryPoint\UserEntryPoint;
use App\Symfony\ApiResponseWrapper;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    /**
     * @var UserEntryPoint $userEntryPoint
     */
    private $userEntryPoint;
    /**
     * @var ApiResponseWrapper $apiResponseWrapper
     */
    private $apiResponseWrapper;
    /**
     * UserController constructor.
     * @param UserEntryPoint $userEntryPoint
     * @param ApiResponseWrapper $apiResponseWrapper
     */
    public function __construct(
        UserEntryPoint $userEntryPoint,
        ApiResponseWrapper $apiResponseWrapper
    ) {
        $this->userEntryPoint = $userEntryPoint;
        $this->apiResponseWrapper = $apiResponseWrapper;
    }
    /**
     * @param User $user
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(User $user): Response
    {
        /** @var LayerPropagationResourceResponse $propagationResponse */
        $propagationResponse = $this->userEntryPoint->create($user);

        return $this->apiResponseWrapper->createUserCreate($propagationResponse->toArray());
    }
}