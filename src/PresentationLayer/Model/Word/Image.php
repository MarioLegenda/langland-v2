<?php

namespace App\PresentationLayer\Model\Word;

use App\PresentationLayer\Model\PresentationModelInterface;
use Library\Infrastructure\FileUpload\Implementation\UploadedFile;

class Image implements PresentationModelInterface
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
}