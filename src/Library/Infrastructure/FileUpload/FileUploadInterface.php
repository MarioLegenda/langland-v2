<?php

namespace Library\Infrastructure\FileUpload;

use Library\Infrastructure\FileUpload\Implementation\UploadedFile;

interface FileUploadInterface
{
    /**
     * @param UploadedFile $fileInfo
     * @param array $options
     * @return mixed
     */
    public function upload(UploadedFile $fileInfo, array $options = array());
    /**
     * @return iterable
     */
    public function getData(): iterable;
}