<?php

namespace App\Symfony\Resolver;

use Library\Http\Request\Contract\PaginatedInternalizedRequestInterface;
use Library\Http\Request\Contract\PaginatedRequestInterface;
use Library\Http\Request\Type\InternalTypeType;
use Library\Http\Request\Uniformity\PaginatedInternalizedRequest;
use Library\Http\Request\Uniformity\PaginatedRequest;
use Library\Http\Request\Uniformity\UniformRequestResolverFactory;
use Library\Infrastructure\Notation\ArrayNotationInterface;
use Library\Infrastructure\Type\TypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class PaginatedRequestResolver implements ArgumentValueResolverInterface
{
    use ResolvableRequestValidator;
    /**
     * @var PaginatedRequestInterface $paginatedRequest
     */
    private $paginatedRequest;
    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        if (
            PaginatedInternalizedRequestInterface::class !== $argument->getType() and
            PaginatedRequestInterface::class !== $argument->getType()
        ) {
            return false;
        }

        $httpData = $this->getHttpData($request);
        if (is_null($httpData)) {
            return false;
        }

        $uniformedRequest = UniformRequestResolverFactory::create($httpData);

        /** @var TypeInterface|ArrayNotationInterface $internalType */
        $internalType = InternalTypeType::fromValue($httpData['internalType']);
        $data = $uniformedRequest->getData();

        if ($internalType->equalsValue('paginated_internalized_view')) {
            $this->paginatedRequest = new PaginatedInternalizedRequest(
                $data['offset'],
                $data['limit'],
                $data['locale']
            );
        } else if ($internalType->equalsValue('paginated_view')) {
            $this->paginatedRequest = new PaginatedRequest(
                $data['offset'],
                $data['limit']
            );
        }

        if (!$this->paginatedRequest instanceof PaginatedRequestInterface) {
            $message = sprintf(
                'Invalid paginated request name given. \'internal_type\' can only be one of \'%s\'. \'%s\' given',
                implode(', ', $internalType->toArray()),
                $internalType->getValue()
            );

            throw new \RuntimeException($message);
        }

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
        yield $this->paginatedRequest;
    }
}