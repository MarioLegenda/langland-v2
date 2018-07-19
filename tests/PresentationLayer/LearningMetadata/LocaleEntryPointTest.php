<?php

namespace App\Tests\PresentationLayer\LearningMetadata;

use App\LogicLayer\LearningMetadata\Domain\Locale;
use App\LogicLayer\LearningMetadata\Model\LocaleCollection;
use App\PresentationLayer\LearningMetadata\EntryPoint\LocaleEntryPoint;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Library\Http\Request\Uniformity\PaginatedRequest;
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

        $localeData = [
            'name' => 'en',
            'default' => true,
        ];

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

        $localeData = [
            'name' => 'en',
            'default' => true,
        ];

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

    public function test_existing_default_locale_failure()
    {
        /** @var LocaleEntryPoint $localeEntryPoint */
        $localeEntryPoint = static::$container->get(LocaleEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

        $localeData = [
            'name' => 'en',
            'default' => true,
        ];

        $localeModel = $presentationModelDataProvider->getLocaleModel($localeData);

        $localeEntryPoint->create($localeModel);

        $enteredExistingLocaleException = false;
        try {
            /** @var PresentationModelDataProvider $presentationModelDataProvider */
            $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

            $localeData = [
                'name' => 'fr',
                'default' => true,
            ];

            $localeModel = $presentationModelDataProvider->getLocaleModel($localeData);

            $localeEntryPoint->create($localeModel);
        } catch (\RuntimeException $e) {
            $enteredExistingLocaleException = true;
        }

        static::assertTrue($enteredExistingLocaleException);
    }

    public function test_get_all_locales()
    {
        /** @var LocaleEntryPoint $localeEntryPoint */
        $localeEntryPoint = static::$container->get(LocaleEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

        /** @var array $localeModels */
        $localeModels = $presentationModelDataProvider->getMultipleLocaleModels(3);

        foreach ($localeModels as $localeModel) {
            $localeModel = $presentationModelDataProvider->getLocaleModel($localeModel);

            $localeEntryPoint->create($localeModel);
        }

        $paginationRequest = new PaginatedRequest(0, 10);

        /** @var LocaleCollection $locales */
        $locales = $localeEntryPoint->getAll($paginationRequest);

        $propagationObjects = $locales->getPropagationObjects();

        static::assertEquals(count($localeModels), count($propagationObjects));

        $localeArray = $locales->toArray();

        foreach ($localeArray as $item) {
            static::assertInternalType('int', $item['id']);
            static::assertInternalType('string', $item['name']);
            static::assertNotEmpty('string', $item['name']);
            static::assertInternalType('bool', $item['default']);
            static::assertTrue(Util::isValidDate($item['createdAt']));
            static::assertNull($item['updatedAt']);
        }
    }
}