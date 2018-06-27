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
            ->method('PUT')
            ->addMessage('Language created')
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
    /**
     * @param array $data
     * @param string $type
     * @return JsonResponse
     */
    public function createCategoryCreate($data = [], string $type = 'json')
    {
        /** @var ApiResponseData $responseData */
        $responseData = $this->apiSdk
            ->create($data)
            ->method('PUT')
            ->addMessage('Category created')
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
    /**
     * @param array $data
     * @param string $type
     * @return JsonResponse
     */
    public function createWordCreate($data = [], string $type = 'json')
    {
        /** @var ApiResponseData $responseData */
        $responseData = $this->apiSdk
            ->create($data)
            ->method('PUT')
            ->addMessage('Word created')
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
    /**
     * @param array $data
     * @param string $type
     * @return JsonResponse
     */
    public function createLessonCreate($data = [], string $type = 'json')
    {
        /** @var ApiResponseData $responseData */
        $responseData = $this->apiSdk
            ->create($data)
            ->method('PUT')
            ->addMessage('Lesson created')
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
    /**
     * @param array $data
     * @param string $type
     * @return JsonResponse
     */
    public function createGetLanguages($data = [], string $type = 'json')
    {
        /** @var ApiResponseData $responseData */
        $responseData = $this->apiSdk
            ->create($data)
            ->method('GET')
            ->addMessage('A list of languages')
            ->isCollection()
            ->setStatusCode(200)
            ->build();

        switch ($type) {
            case 'json': return new JsonResponse(
                $responseData->toArray(),
                $responseData->getStatusCode()
            );
        }
    }
    /**
     * @param array $data
     * @param string $type
     * @return JsonResponse
     */
    public function createCreateLocale($data = [], string $type = 'json')
    {
        /** @var ApiResponseData $responseData */
        $responseData = $this->apiSdk
            ->create($data)
            ->method('PUT')
            ->addMessage('Locale created')
            ->isCollection()
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