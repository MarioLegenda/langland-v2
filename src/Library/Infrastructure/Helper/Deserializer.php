<?php

namespace Library\Infrastructure\Helper;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Deserializer
{
    /**
     * @var Serializer $serializer
     */
    private $serializer;
    /**
     * Deserializer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }
    /**
     * @param $data
     * @param $type
     * @param string|null $format
     * @return object
     */
    public function create($data, $type, string $format = null): object
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }

        if (!is_string($format)) {
            $format = 'json';
        }

        if (!is_string($type) and !is_object($type)) {
            throw new \RuntimeException('$type has to be a string or an object');
        }

        if (is_object($type)) {
            $type = get_class($type);
        }

        return $this->serializer->deserialize($data, $type, $format);
    }
}