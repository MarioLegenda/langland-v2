<?php

namespace App\Symfony\Resolver;

use App\Library\Http\Request\Uniformity\UniformRequestResolverFactory;
use App\PresentationLayer\Infrastructure\Model\User;
use Library\Infrastructure\Helper\SerializerWrapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class UserResolver implements ArgumentValueResolverInterface
{
    use ResolvableRequestValidator;
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var User $user
     */
    private $user;
    /**
     * UserResolver constructor.
     * @param SerializerWrapper $serializerWrapper
     */
    public function __construct(
        SerializerWrapper $serializerWrapper
    ) {
        $this->serializerWrapper = $serializerWrapper;
    }
    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        $httpData = $this->getHttpData($request);
        if (is_null($httpData)) {
            return false;
        }

        $uniformedRequest = UniformRequestResolverFactory::create($httpData);

        $user = $this->serializerWrapper->convertFromToByArray(
            $uniformedRequest->getData(),
            User::class
        );

        if (!$user instanceof User) {
            return false;
        }

        $this->user = $user;

        return true;
    }
    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return \Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield $this->user;
    }
}