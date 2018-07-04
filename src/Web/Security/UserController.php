<?php

namespace App\Web\Security;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\PresentationLayer\Infrastructure\Model\User;
use App\PresentationLayer\Security\EntryPoint\UserEntryPoint;
use App\Symfony\ApiResponseWrapper;
use Library\Util\Util;
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

    public function getLoggedInUser(): Response
    {
        // temporary code that will be deleted after security is finished

        return $this->apiResponseWrapper->createGetLoggedInUser([
            'id' => 1,
            'name' => 'Mile',
            'lastname' => 'Mile',
            'username' => 'mile123',
            'email' => 'mile@gmail.com',
            'enabled' => true,
            'locale' => [
                'id' => 1,
                'name' => 'en',
                'default' => true,
                'createdAt' => Util::formatFromDate(Util::toDateTime()),
                'updatedAt' => null,
            ],
            'createdAt' => Util::formatFromDate(Util::toDateTime()),
            'updatedAt' => null,
        ]);
    }
}