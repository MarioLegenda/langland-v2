<?php

namespace App\PresentationLayer\Model\Word;

use App\PresentationLayer\Model\PresentationModelInterface;
use Library\Infrastructure\FileUpload\Implementation\UploadedFile;

class Image implements PresentationModelInterface
{
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
     * @return UploadedFile
     */
    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }
}