<?php

namespace App\Symfony\Resolver;

use App\PresentationLayer\Infrastructure\Model\User;
use Library\Http\Request\ResolvedRequestResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class UserResolver implements ArgumentValueResolverInterface
{
    use ResolvableRequestValidator;
    /**
     * @var ResolvedRequestResolver $resolvedRequestResolver
     */
    private $resolvedRequestResolver;
    /**
     * @var User $user
     */
    private $user;
    /**
     * UserResolver constructor.
     * @param ResolvedRequestResolver $resolvedRequestResolver
     */
    public function __construct(
        ResolvedRequestResolver $resolvedRequestResolver
    ) {
        $this->resolvedRequestResolver = $resolvedRequestResolver;
    }
    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        $httpData = $this->getHttpData($request);
        if ($httpData === false) {
            return false;
        }

        /** @var array $httpData */
        $httpData = $this->getHttpData($request);
        if ($httpData === false) {
            return false;
        }

        $resolvedData = $this->resolvedRequestResolver->resolveTo(
            User::class,
            $httpData
        );

        $request->request->set('resolved_request', $resolvedData['resolvedRequest']);

        $this->user = $resolvedData['model'];
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