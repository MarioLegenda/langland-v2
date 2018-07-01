<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\DataSourceGateway\Gateway\LanguageGateway;
use App\Infrastructure\Response\LayerPropagationCollectionResponse;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\Library\Http\Request\Contract\PaginatedInternalizedRequestInterface;
use App\Library\Http\Request\Contract\PaginatedRequestInterface;
use App\LogicLayer\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Image;
use App\LogicLayer\LearningMetadata\Domain\Language;
use App\LogicLayer\LearningMetadata\Model\LanguageCollection;
use App\LogicLayer\LogicInterface;
use App\LogicLayer\LearningMetadata\Model\Language as LanguageResponseModel;
use Library\Infrastructure\FileUpload\Implementation\ImageUpload;
use App\LogicLayer\LearningMetadata\Model\Language as LanguageModel;

class LanguageLogic implements LogicInterface
{
    /**
     * @var LanguageGateway $languageGateway
     */
    private $languageGateway;
    /**
     * @var ImageUpload $imageUpload
     */
    private $imageUpload;
    /**
     * LanguageLogic constructor.
     * @param LanguageGateway $languageGateway
     * @param ImageUpload $imageUpload
     */
    public function __construct(
        LanguageGateway $languageGateway,
        ImageUpload $imageUpload
    ) {
        $this->languageGateway = $languageGateway;
        $this->imageUpload = $imageUpload;
    }
    /**
     * @param DomainModelInterface|Language $model
     * @return LayerPropagationResourceResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $model): LayerPropagationResourceResponse
    {
        $this->imageUpload->upload(
            $model->getImage()->getUploadedFile()
        );

        $data = $this->imageUpload->getData();

        $image = new Image();
        $image->setName($data['fileName']);
        $image->setRelativePath($data['relativePath']);

        $model->setImage($image);

        /** @var DomainModelInterface $newLanguage */
        $newLanguage = $this->languageGateway->create($model);

        return new LanguageResponseModel($newLanguage);
    }
    /**
     * @param PaginatedInternalizedRequestInterface $paginatedInternalizedRequest
     * @return LayerPropagationCollectionResponse
     */
    public function getLanguages(PaginatedInternalizedRequestInterface $paginatedInternalizedRequest): LayerPropagationCollectionResponse
    {
        /** @var DomainModelInterface[]|Language[]|iterable $languages */
        $languages = $this->languageGateway->getLanguages($paginatedInternalizedRequest);

        $languageModels = [];
        /** @var DomainModelInterface|Language $language */
        foreach ($languages as $language) {
            $languageModels[] = new LanguageModel($language);
        }

        return new LanguageCollection(
            $languageModels,
            true
        );
    }
}