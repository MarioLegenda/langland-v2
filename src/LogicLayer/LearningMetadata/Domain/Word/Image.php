<?php

namespace App\LogicLayer\LearningMetadata\Domain\Word;

use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use Library\Infrastructure\FileUpload\Implementation\UploadedFile;

class Image implements DomainModelInterface
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getRelativePath(): string
    {
        return $this->relativePath;
    }
    /**
     * @param string $relativePath
     */
    public function setRelativePath(string $relativePath): void
    {
        $this->relativePath = $relativePath;
    }
    /**
     * @return string
     */
    public function getFullRelativePath(): string
    {
        return sprintf('%s%s', $this->relativePath, $this->name);
    }
    /**
     * @param UploadedFile $uploadedFile
     */
    public function setUploadedFile(UploadedFile $uploadedFile): void
    {
        $this->uploadedFile = $uploadedFile;
    }
    /**
     * @return UploadedFile
     */
    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }
}