<?php

namespace App\Symfony\Resolver;

use App\PresentationLayer\Model\Language;
use Library\Http\Request\RequestDataModel;
use Library\Http\Request\ResolvedRequest;
use Library\Infrastructure\Helper\SerializerWrapper;
use Library\Validation\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class LanguageResolver implements ArgumentValueResolverInterface
{
    use ResolvableRequestValidator;
    /**
     * @var ValidatorInterface $validator
     */
    private $validator;
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var Language
     */
    private $languageModel;
    /**
     * LanguageResolver constructor.
     * @param ValidatorInterface $validator
     * @param SerializerWrapper $serializerWrapper
     */
    public function __construct(
        ValidatorInterface $validator,
        SerializerWrapper $serializerWrapper
    ) {
        $this->validator = $validator;
        $this->serializerWrapper = $serializerWrapper;
    }
    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        /** @var array $httpData */
        $httpData = $this->getHttpData($request);
        if ($httpData === false) {
            return false;
        }

        /** @var RequestDataModel $requestDataModel */
        $requestDataModel = $this->serializerWrapper->getDeserializer()->create($httpData, RequestDataModel::class);

        $resolvedRequest = new ResolvedRequest(
            $requestDataModel,
            $this->validator
        );

        $request->request->set('resolved_request', $resolvedRequest);

        /** @var Language languageModel */
        $this->languageModel = $this->serializerWrapper->convertFromToByArray(
            $resolvedRequest->toArray(),
            Language::class
        );

        return true;
    }
    /**
     * Returns the possible value(s).
     *
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return \Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        yield $this->languageModel;
    }
}