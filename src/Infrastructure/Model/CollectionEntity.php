<?php

namespace App\Infrastructure\Model;

class CollectionEntity implements \IteratorAggregate
{
    /**
     * @var CollectionMetadata[] $categoryMetadata
     */
    private $metadata = [];
    /**
     * @param CollectionMetadata $collectionMetadata
     */
    public function addMetadata(CollectionMetadata $collectionMetadata): void
    {
        $this->metadata[] = $collectionMetadata;
    }
    /**
     * @param iterable $collectionMetadata
     */
    public function setCollectionMetadata(iterable $collectionMetadata)
    {
        $this->metadata = $collectionMetadata;
    }
    /**
     * @return array
     */
    public function getCategoryMetadata(): array
    {
        return $this->metadata;
    }
    /**
     * @return array
     */
    public function validate(): array
    {
        $messages = [
            'valid' => false,
            'message' => [],
        ];

        if (empty($this->metadata)) {
            $message = sprintf(
                'Metadata cannot be empty'
            );

            $messages['message'] = sprintf('%s | %s', $messages['message'], $message);
        }

        if (empty($messages['message'])) {
            $messages['valid'] = true;
        }

        return $messages;
    }
    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->metadata);
    }
}