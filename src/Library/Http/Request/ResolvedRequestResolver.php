<?php

namespace Library\Http\Request;

use Library\Infrastructure\Helper\SerializerWrapper;
use Library\Infrastructure\Helper\TypedArray;
use Library\Validation\ValidatorInterface;

class ResolvedRequestResolver
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var ValidatorInterface $validator
     */
    private $validator;
    /**
     * ResolvedRequestResolver constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ValidatorInterface $validator
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ValidatorInterface $validator
    ) {
        $this->serializerWrapper = $serializerWrapper;
        $this->validator = $validator;
    }
    /**
     * @param string $class
     * @param array $data
     * @return array
     */
    public function resolveTo(string $class, array $data): iterable
    {
        /** @var RequestDataModel $requestDataModel */
        $requestDataModel = $this->serializerWrapper->getDeserializer()->create($data, RequestDataModel::class);

        $resolvedRequest = new ResolvedRequest(
            $requestDataModel,
            $this->validator
        );

        /** @var object $languageModel */
        $languageModel = $this->serializerWrapper->convertFromToByArray(
            $resolvedRequest->toArray(),
            $class
        );

        if (get_class($languageModel) !== $class) {
            $message = sprintf(
                'Invalid model resolved. Expected \'%s\' got \'%s\'',
                $class,
                get_class($languageModel)
            );

            throw new \RuntimeException($message);
        }

        return TypedArray::create('string', 'object', [
            'resolvedRequest' => $resolvedRequest,
            'model' => $languageModel,
        ]);
    }
}