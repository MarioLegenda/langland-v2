<?php

namespace App\Tests\Unit;

use App\Tests\Library\BasicSetup;
use App\Tests\Library\DummyObject;
use App\Tests\Library\FakerTrait;
use Library\Util\Util;

class UtilTest extends BasicSetup
{
    use FakerTrait;

    public function test_to_date_time()
    {
        $todayDate = Util::toDateTime();

        static::assertEquals(
            (new \DateTime())->format('Y-m-d'),
            $todayDate->format('Y-m-d')
        );

        $sameDate = Util::toDateTime($todayDate);

        static::assertEquals(
            $sameDate->format('Y-m-d'),
            $todayDate->format('Y-m-d')
        );

        $yesterday = new \DateTime();
        $interval = new \DateInterval('P1D');
        $yesterday->sub($interval);

        static::assertInstanceOf(\DateTime::class, Util::toDateTime($yesterday));
        static::assertEquals($yesterday->format('Y-m-d'), Util::toDateTime($yesterday)->format('Y-m-d'));

        $yesterdayAsString = Util::toDateTime($yesterday->format('Y-m-d H:m:s'));

        static::assertInstanceOf(\DateTime::class, $yesterdayAsString);
        static::assertEquals(
            $yesterdayAsString->format('Y-m-d H:m:s'),
            Util::toDateTime($yesterdayAsString->format('Y-m-d H:m:s'))->format('Y-m-d H:m:s')
        );

        $timestamp = time();
        $timestampDateTime = new \DateTime('@'.$timestamp);
        $utilTimestampDateTime = Util::toDateTime($timestamp);

        static::assertEquals(
            $timestampDateTime->format('Y-m-d H:m:s'),
            $utilTimestampDateTime->format('Y-m-d H:m:s')
        );
    }

    public function test_is_valid_date()
    {
        $datetime = new \DateTime();

        static::assertTrue(Util::isValidDate($datetime->format('Y-m-d H:m:s')));
        static::assertFalse(Util::isValidDate('dkfjaslkdf'));
    }

    public function test_object_field_extractors()
    {
        $dummyObject = new DummyObject();
        $dummyObject->setId(4);
        $dummyObject->setName($this->faker()->name);

        static::assertEquals(
            Util::extractFieldFromObject($dummyObject, 'id'),
            $dummyObject->getId()
        );

        $extractedFields = Util::extractFieldsFromObject($dummyObject, [
            'id',
            'name',
        ]);

        static::assertInternalType('array', $extractedFields);
        static::assertNotEmpty($extractedFields);
        static::assertEquals($extractedFields['id'], $dummyObject->getId());
        static::assertEquals($extractedFields['name'], $dummyObject->getName());

        $dummy1 = new DummyObject();
        $dummy1->setName($this->faker()->name);
        $dummy1->setId($this->faker()->numberBetween(1, 10));

        $dummy2 = new DummyObject();
        $dummy2->setName($this->faker()->name);
        $dummy2->setId($this->faker()->numberBetween(1, 10));

        $extractedFields = Util::extractFieldFromObjects([$dummy1, $dummy2], 'id');

        static::assertInternalType('array', $extractedFields);
        static::assertNotEmpty($extractedFields);
        static::assertEquals(2, count($extractedFields));

        $dummyNotSet = new DummyObject();

        Util::setObjectFieldsByConvention($dummyNotSet, [
            'id' => $this->faker()->numberBetween(1, 10),
            'name' => $this->faker()->name,
        ]);

        static::assertInternalType('int', $dummyNotSet->getId());
        static::assertInternalType('string', $dummyNotSet->getName());
    }
}