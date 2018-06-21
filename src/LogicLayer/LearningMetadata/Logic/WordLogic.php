<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\DataSourceGateway\Gateway\WordGateway;
use App\Infrastructure\Response\LayerPropagationResponse;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Image;
use App\LogicLayer\LearningMetadata\Domain\Word\Word;
use App\LogicLayer\LogicInterface;
use Library\Infrastructure\FileUpload\FileUploadInterface;
use Library\Infrastructure\FileUpload\Implementation\ImageUpload;
use App\LogicLayer\LearningMetadata\Model\Word as WordPropagationResponse;

class WordLogic implements LogicInterface
{
    /**
     * @var FileUploadInterface $fileUpload
     */
    private $fileUpload;
    /**
     * @var WordGateway $wordGateway
     */
    private $wordGateway;
    /**
     * WordLogic constructor.
     * @param ImageUpload $fileUpload
     * @param WordGateway $wordGateway
     */
    public function __construct(
        ImageUpload $fileUpload,
        WordGateway $wordGateway
    ) {
        $this->fileUpload = $fileUpload;
        $this->wordGateway = $wordGateway;
    }
    /**
     * @param DomainModelInterface|Word $wordDomainModel
     * @return LayerPropagationResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(DomainModelInterface $wordDomainModel): LayerPropagationResponse
    {
        $this->fileUpload->upload($wordDomainModel->getImage()->getUploadedFile());

        $data = $this->fileUpload->getData();

        $wordDomainModel->setImage($this->createImageFromUploadedData($data));

        $createdEntries = $this->wordGateway->create($wordDomainModel);

        return new WordPropagationResponse(
            $createdEntries['word'],
            $createdEntries['wordCategories']
        );
    }
    /**
     * @param iterable $data
     * @return Image
     */
    private function createImageFromUploadedData(iterable $data): Image
    {
        $image = new Image();
        $image->setName($data['fileName']);
        $image->setRelativePath($data['relativePath']);

        return $image;
    }
}