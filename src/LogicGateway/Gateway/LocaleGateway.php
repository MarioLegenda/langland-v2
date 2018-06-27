<?php

namespace App\LogicGateway\Gateway;


use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\LearningMetadata\Logic\LocaleLogic;
use App\PresentationLayer\Model\Locale;
use App\PresentationLayer\Model\PresentationModelInterface;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\LogicLayer\LearningMetadata\Domain\Locale as DomainLocale;

class LocaleGateway
{
    /**
     * @var LocaleLogic $localeLogic
     */
    private $localeLogic;
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
        $this->localeLogic = $localeLogic;
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

         return $this->localeLogic->create($domainModel);
     }
}