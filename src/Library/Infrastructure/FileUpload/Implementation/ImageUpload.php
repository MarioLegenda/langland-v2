<?php

namespace Library\Infrastructure\FileUpload\Implementation;

use Library\Infrastructure\FileUpload\Implementation\UploadedFile;
use Library\Infrastructure\FileUpload\FileUploadInterface;
use Library\Infrastructure\FileUpload\FileNamerInterface;
use Library\Infrastructure\FileUpload\ImageResizeInterface;
use Library\Infrastructure\Helper\TypedArray;
use Ramsey\Uuid\Uuid;

class ImageUpload implements FileUploadInterface
{
    /**
     * @var string $imageDir
     */
    private $imageDir;
    /**
     * @var ImageResizeInterface $imageResize
     */
    private $imageResize;
    /**
     * @var mixed $relativePath
     */
    private $relativePath;
    /**
     * @var array $data
     */
    private $data = [];
    /**
     * FileUploader constructor.
     * @param array $imageDirs
     * @param ImageResizeInterface $resizer
     */
    public function __construct(
        array $imageDirs,
        ImageResizeInterface $resizer
    ) {
        $this->imageDir = realpath($imageDirs['image_upload_dir']);
        $this->relativePath = $imageDirs['relative_image_path'];
        $this->imageResize = $resizer;
    }
    /**
     * @inheritdoc
     */
    public function upload(UploadedFile $fileInfo, array $options = array())
    {
        $fileName = sprintf(
            '%s.%s',
            Uuid::uuid4()->toString(), $fileInfo->getExtension()
        );

        $fileName = preg_replace('#-#', '', $fileName);

        $originalName = $fileInfo->getFilename();

        $destination = $this->imageDir.'/'.$fileName;

        if (array_key_exists('resize', $options)) {
            $this->resizeAndSave($options['resize'], $fileInfo, $destination);
        } else {
            $fileInfo->move($fileInfo->getRealPath(), $destination);
        }

        $data = TypedArray::create('string', 'string', [
            'fileName' => $fileName,
            'relativePath' => $this->relativePath,
            'fullRelativePath' => sprintf('%s.%s', $this->relativePath, $fileName),
            'targetDir' => $this->imageDir,
            'originalName' => $originalName,
            'fullPath' => $this->imageDir.'/'.$fileName,
        ]);

        $this->data = $data;
    }
    /**
     * @inheritdoc
     */
    public function getData(): iterable
    {
        if (empty($this->data)) {
            $message = sprintf('Image upload data did not formulate correctly.');

            throw new \RuntimeException($message);
        }

        return $this->data;
    }
    /**
     * @param array $measurements
     * @param $file
     * @param $path
     */
    public function resizeAndSave(array $measurements, $file, $path)
    {
        $this->imageResize
            ->setWidth($measurements['width'])
            ->setHeight($measurements['height'])
            ->resizeAndSave($file, $path);
    }
}