<?php

namespace App\LogicLayer\LearningMetadata\Domain;

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
     * @var \DateTime $createdAt
     */
    private $createdAt;
    /**
     * @var \DateTime $updatedAt
     */
    private $updatedAt;
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
    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}