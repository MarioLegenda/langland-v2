<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\DataSourceGateway\Gateway\WordGateway;
use App\Infrastructure\Model\CollectionEntity;
use App\Infrastructure\Model\CollectionMetadata;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Word\Image;
use App\LogicLayer\LearningMetadata\Domain\Word\Word;
use App\LogicLayer\LogicInterface;
use Library\Infrastructure\FileUpload\FileUploadInterface;
use Library\Infrastructure\FileUpload\Implementation\ImageUpload;

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
     * @return DomainModelInterface
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(DomainModelInterface $wordDomainModel): DomainModelInterface
    {
        $this->fileUpload->upload($wordDomainModel->getImage()->getUploadedFile());

        $data = $this->fileUpload->getData();

        $image = new Image();
        $image->setName($data['fileName']);
        $image->setRelativePath($data['relativePath']);

        $wordDomainModel->setImage($image);

        return $this->wordGateway->create($wordDomainModel);
    }
}