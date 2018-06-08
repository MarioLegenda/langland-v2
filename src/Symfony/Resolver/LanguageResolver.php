<?php

namespace App\Symfony\Resolver;

use Library\Http\Request\ResolvedRequest;
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
     * LanguageResolver constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(
        ValidatorInterface $validator
    ) {
        $this->validator = $validator;
    }
    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        /** @var array $httpData */
        $httpData = $this->validate($request);
        if ($httpData === false) {
            return false;
        }

        $requestResolver = new ResolvedRequest(
            $httpData,
            $this->validator
        );


    }

    /**
     * Returns the possible value(s).
     *
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return \Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
    }
}