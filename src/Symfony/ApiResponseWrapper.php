<?php

namespace App\Symfony;

use Library\Util\ApiResponseData;
use Library\Util\ApiSDK;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseWrapper
{
    /**
     * @var ApiSDK $apiSdk
     */
    private $apiSdk;
    /**
     * ApiResponseWrapper constructor.
     * @param ApiSDK $apiSDK
     */
    public function __construct(
        ApiSDK $apiSDK
    ) {
        $this->apiSdk = $apiSDK;
    }

    /**
     * @param string $type
     * @param array $data
     * @return Response
     */
    public function createLanguageCreate($data = [], string $type = 'json'): Response
    {
        /** @var ApiResponseData $responseData */
        $responseData = $this->apiSdk
            ->create($data)
            ->method('GET')
            ->addMessage('LanguageEntryPoint created')
            ->isResource()
            ->setStatusCode(201)
            ->build();

        switch ($type) {
            case 'json': return new JsonResponse(
                $responseData->toArray(),
                $responseData->getStatusCode()
            );
        }
    }
}