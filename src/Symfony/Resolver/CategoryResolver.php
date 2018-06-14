<?php

namespace App\Symfony\Resolver;

use App\PresentationLayer\Model\Category;
use Library\Http\Request\ResolvedRequestResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class CategoryResolver implements ArgumentValueResolverInterface
{
    use ResolvableRequestValidator;
    /**
     * @var ResolvedRequestResolver $resolvedRequestResolver
     */
    private $resolvedRequestResolver;
    /**
     * @var Category
     */
    private $categoryModel;
    /**
     * LanguageResolver constructor.
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
        /** @var array $httpData */
        $httpData = $this->getHttpData($request);
        if ($httpData === false) {
            return false;
        }

        $resolvedData = $this->resolvedRequestResolver->resolveTo(
            Category::class,
            $httpData
        );

        $request->request->set('resolved_request', $resolvedData['resolvedRequest']);

        $this->categoryModel = $resolvedData['model'];

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
        yield $this->categoryModel;
    }
}