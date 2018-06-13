<?php

namespace Library\Infrastructure\Helper;

class TypedArray extends \ArrayIterator implements \Countable, \ArrayAccess
{
    /**
     * @var string $keyType
     */
    private $keyType;
    /**
     * @var string $valueType
     */
    private $valueType;
    /**
     * @var array $possibleTypes
     */
    private $possibleTypes = [
        'boolean',
        'integer',
        'double',
        'float',
        'string',
        'array',
        'object',
        'resource',
        'NULL',
        'unknown type'
    ];
    /**
     * @var array $data
     */
    private $data;
    /**
     * @param string $keyType
     * @param string $valueType
     * @param iterable $data
     * @return TypedArray
     */
    public static function create(
        string $keyType,
        string $valueType,
        iterable $data = []
    ): TypedArray {
        return new static($keyType, $valueType, $data);
    }
    /**
     * TypedArray constructor.
     * @param string $keyType
     * @param string $valueType
     * @param iterable $data
     */
    private function __construct(
        string $keyType,
        string $valueType,
        iterable $data = []
    ) {
        $this->keyType = $keyType;
        $this->valueType = $valueType;
        $this->data = $data;
    }
    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return count($this->data);
    }
    /**
     * @inheritdoc
     */
    public function offsetExists($offset): bool
    {
        $this->validateOffset($offset);

        return array_key_exists($offset, $this->data);
    }
    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        $this->validateOffset($offset);

        return $this->data[$offset];
    }
    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        $this->validateOffset($offset);
        $this->validateValue($value);

        $this->data[$offset] = $value;
    }
    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        $this->validateOffset($offset);

        unset($this->data[$offset]);
    }
    /**
     * @param mixed $type
     * @return bool
     * @throws \RuntimeException
     */
    private function checkType($type): bool
    {
        $type = gettype($type);

        if (in_array($type, $this->possibleTypes) === false) {
            $message = sprintf(
                'Invalid type \'%s\'. Possible types are \'\'',
                $type,
                implode(', ', $this->possibleTypes)
            );

            throw new \RuntimeException($message);
        }

        return $type === $this->keyType;
    }
    /**
     * @param $value
     */
    private function validateValue($value)
    {
        if ($this->valueType === 'object') {
            if (!is_object($value)) {
                $message = sprintf(
                    'Invalid value type given. Value has to be of type \'%s\'',
                    $this->valueType
                );

                throw new \RuntimeException($message);
            }
        }

        if ($this->valueType === 'object') {
            if (!is_object($value)) {
                $message = sprintf(
                    'Invalid value given. Value should be of type \'%s\'',
                    $this->valueType
                );

                throw new \RuntimeException($message);
            }
        }

        if (class_exists($this->valueType)) {
            if (ucfirst(get_class($value)) !== $this->valueType) {
                $message = sprintf(
                    'Invalid value given. Value should be of type \'%s\'',
                    $this->valueType
                );

                throw new \RuntimeException($message);
            }
        }

        if (!is_object($value)) {
            $type = gettype($value);

            if ($type !== $this->valueType) {
                $message = sprintf(
                    'Invalid value type given. Value type should be \'%s\'',
                    $this->valueType
                );

                throw new \RuntimeException($message);
            }
        }
    }
    /**
     * @param mixed $offset
     * @throws \RuntimeException
     */
    private function validateOffset($offset)
    {
        if (!$this->checkType($offset)) {
            $message = sprintf(
                'Invalid offset \'%s\' given. Registered type is \'%s\'',
                $offset,
                $this->keyType
            );

            throw new \RuntimeException($message);
        }
    }
}