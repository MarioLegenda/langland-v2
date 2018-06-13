<?php

namespace Library\Infrastructure\Helper;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;

class SerializerWrapper
{
    /**
     * @var Serializer $serializer
     */
    private $serializer;
    /**
     * @var Deserializer $deserializer
     */
    private $deserializer;
    /**
     * SerializerWrapper constructor.
     * @param SerializerInterface $serializer
     * @param Deserializer $deserializer
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        SerializerInterface $serializer,
        Deserializer $deserializer
    ) {
        $this->serializer = $serializer;
        $this->deserializer = $deserializer;
    }
    /**
     * @param $object
     * @param array|string $groups
     * @param string $type
     * @return string
     */
    public function serialize($object, $groups, $type = 'json'): string
    {
        $context = new SerializationContext();
        $context->setGroups($this->normalizeGroups($groups));

        return $this->serializer->serialize($object, $type, $context);
    }
    /**
     * @param object $object
     * @param array|string $groups
     * @param string $type
     * @return array
     */
    public function normalize(object $object, $groups, $type = 'json'): array
    {
        $serialized = $this->serialize($object, $groups, $type);

        return json_decode($serialized, true);
    }
    /**
     * @param array $objectsArray
     * @param array $groups
     * @param string $type
     * @return string
     */
    public function serializeMany(array $objectsArray, array $groups, $type = 'json'): string
    {
        $arrayed = [];
        foreach ($objectsArray as $object) {
            $arrayed[] = json_decode($this->serialize($object, $groups, $type), true);
        }

        return json_encode($arrayed);
    }
    /**
     * @param object $object
     * @param array|string $groups
     * @param string $class
     * @return object
     */
    public function convertFromToByGroup(
        object $object,
        $groups,
        string $class
    ): object {
        $serialized = $this->serialize($object, $this->normalizeGroups($groups));

        $created = $this->getDeserializer()->create($serialized, $class);

        return $created;
    }
    /**
     * @param array $data
     * @param string $class
     * @return object
     */
    public function convertFromToByArray(
        array $data,
        string $class
    ): object {
        $created = $this->getDeserializer()->create($data, $class);

        return $created;
    }
    /**
     * @param $data
     * @param $type
     * @param string $format
     * @return object
     */
    public function deserialize($data, $type, $format = 'json'): object
    {
        return $this->deserializer->create($data, $type, $format);
    }
    /**
     * @return Deserializer
     */
    public function getDeserializer(): Deserializer
    {
        return $this->deserializer;
    }
    /**
     * @param array|string $groups
     * @return array
     */
    private function normalizeGroups($groups): array
    {
        if (!is_array($groups) and !is_string($groups)) {
            $message = sprintf(
                '$groups can only be an array or a string'
            );

            throw new \RuntimeException($message);
        }

        if (is_array($groups)) {
            return $groups;
        }

        if (is_string($groups)) {
            return [$groups];
        }
    }
}