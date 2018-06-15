<?php

namespace Library\Infrastructure\FileUpload\Implementation;

class UploadedFile extends \SplFileInfo
{
    /**
     * @param string $source
     * @param string $destination
     * @throws \RuntimeException
     */
    public function move(string $source, string $destination): void
    {
        $hasMoved = move_uploaded_file($source, $destination);

        if (!$hasMoved) {
            $message = sprintf(
                'File could not be moved to destination \'%s\'',
                $destination
            );

            throw new \RuntimeException($message);
        }
    }
}