<?php

namespace App\Tests\PresentationLayer;

use App\PresentationLayer\LearningMetadata\EntryPoint\LocaleEntryPoint;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Library\Util\Util;
use Symfony\Component\HttpFoundation\Response;

class LocaleEntryPointTest extends BasicSetup
{
    public function test_create_locale()
    {
        /** @var LocaleEntryPoint $localeEntryPoint */
        $localeEntryPoint = static::$container->get(LocaleEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

        $localeData = ['name' => 'en'];

        $localeModel = $presentationModelDataProvider->getLocaleModel($localeData);

        $response = $localeEntryPoint->create($localeModel);

        static::assertInstanceOf(Response::class, $response);
        static::assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true)['resource']['data'];

        static::assertInternalType('int', $responseData['id']);
        static::assertInternalType('string', $responseData['name']);
        static::assertNotEmpty($responseData['name']);
        static::assertEquals($responseData['name'], $localeData['name']);
        static::assertTrue(Util::isValidDate($responseData['createdAt']));
        static::assertNull($responseData['updatedAt']);
    }

    public function test_existing_locale_failure()
    {
        /** @var LocaleEntryPoint $localeEntryPoint */
        $localeEntryPoint = static::$container->get(LocaleEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

        $localeData = ['name' => 'en'];

        $localeModel = $presentationModelDataProvider->getLocaleModel($localeData);

        $localeEntryPoint->create($localeModel);

        $enteredExistingLocaleException = false;
        try {
            $localeEntryPoint->create($localeModel);
        } catch (\RuntimeException $e) {
            $enteredExistingLocaleException = true;
        }

        static::assertTrue($enteredExistingLocaleException);
    }
}