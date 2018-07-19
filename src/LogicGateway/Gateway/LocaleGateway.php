<?php

namespace App\LogicGateway\Gateway;


use App\Infrastructure\Response\LayerPropagationCollectionResponse;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\LearningMetadata\Logic\LocaleLogic;
use App\LogicLayer\LearningMetadata\Model\LocaleCollection;
use App\PresentationLayer\Infrastructure\Model\Locale;
use App\PresentationLayer\Infrastructure\Model\PresentationModelInterface;
use Library\Http\Request\Contract\PaginatedRequestInterface;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\LogicLayer\LearningMetadata\Domain\Locale as DomainLocale;

class LocaleGateway
{
    /**
     * @var LocaleLogic $logic
     */
    private $logic;
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * LocaleGateway constructor.
     * @param LocaleLogic $localeLogic
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        LocaleLogic $localeLogic,
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator
    ) {
        $this->logic = $localeLogic;
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
    }
    /**
     * @param PresentationModelInterface $locale
     * @return LayerPropagationResourceResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
     public function create(PresentationModelInterface $locale): LayerPropagationResourceResponse
     {
         $this->modelValidator->validate($locale);

         /** @var DomainLocale $domainModel */
         $domainModel = $this->serializerWrapper->convertFromToByGroup(
             $locale,
             'default',
             DomainLocale::class
         );

         $this->modelValidator->validate($domainModel);

         return $this->logic->create($domainModel);
     }

     public function getAll(PaginatedRequestInterface $paginatedRequest): LayerPropagationCollectionResponse
     {
         /** @var LocaleCollection $languages */
         $locales = $this->logic->getAll($paginatedRequest);

         return $locales;
     }
}