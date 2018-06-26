<?php

namespace App\Tests\Unit;

use App\Tests\Library\BasicSetup;
use App\Tests\Library\DummyObject;
use Library\Infrastructure\Helper\TypedArray;

class TypedArrayTest extends BasicSetup
{
    public function test_typed_array()
    {
        $array = TypedArray::create('string', 'string');

        static::assertTrue(is_iterable($array));

        $array['string'] = 'string';

        static::assertEquals('string', $array['string']);

        $enteredInvalidType = false;
        try {
            $array[0] = 'string';
        } catch (\RuntimeException $e) {
            $enteredInvalidType = true;
        }

        static::assertTrue($enteredInvalidType);

        $enteredInvalidType = false;
        try {
            $array['string'] = 0;
        } catch (\RuntimeException $e) {
            $enteredInvalidType = true;
        }

        static::assertTrue($enteredInvalidType);

        $objectArray = TypedArray::create('string', 'object');

        $objectArray['object1'] = new \StdClass();

        static::assertInstanceOf(\StdClass::class, $objectArray['object1']);

        $enteredInvalidType = false;
        try {
            $objectArray['string'] = 0;
        } catch (\RuntimeException $e) {
            $enteredInvalidType = true;
        }

        static::assertTrue($enteredInvalidType);

        $objectArray = TypedArray::create('string', \StdClass::class);

        $objectArray['object1'] = new \StdClass();

        $enteredInvalidType = false;
        try {
            $objectArray['object2'] = new DummyObject();
            $objectArray['object1'] = new DummyObject();
        } catch (\RuntimeException $e) {
            $enteredInvalidType = true;
        }

        static::assertTrue($enteredInvalidType);

        $objectArray = TypedArray::create(
            'integer',
            \StdClass::class,
            [
                new \StdClass(),
                new \StdClass(),
                new \StdClass(),
            ]
        );

        static::assertInstanceOf(\StdClass::class, $objectArray[0]);
        static::assertInstanceOf(\StdClass::class, $objectArray[1]);
        static::assertInstanceOf(\StdClass::class, $objectArray[2]);

        $objectArray = TypedArray::create(
            'integer',
            'object',
            [
                new \StdClass(),
                new \StdClass(),
                new DummyObject(),
            ]
        );

        $count = 0;
        foreach ($objectArray as $item) {
            $count++;
        }

        static::assertEquals(count($objectArray), $count);

        static::assertInstanceOf(\StdClass::class, $objectArray[0]);
        static::assertInstanceOf(\StdClass::class, $objectArray[1]);
        static::assertInstanceOf(DummyObject::class, $objectArray[2]);
    }
}