<?php

namespace App\PresentationLayer\Model;

use Library\Infrastructure\FileUpload\Implementation\UploadedFile;
use Library\Infrastructure\Notation\ArrayNotationInterface;

class Image implements PresentationModelInterface, ArrayNotationInterface
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var string $relativePath
     */
    private $relativePath;
    /**
     * @var UploadedFile $uploadedFile
     */
    private $uploadedFile;
    /**
     * Image constructor.
     * @param UploadedFile $uploadedFile
     */
    public function __construct(UploadedFile $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return UploadedFile
     */
    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @return string
     */
    public function getRelativePath(): string
    {
        return $this->relativePath;
    }
    /**
     * @inheritdoc
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'relativePath' => $this->getRelativePath(),
        ];
    }
}