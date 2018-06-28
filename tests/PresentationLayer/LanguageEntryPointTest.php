<?php

namespace App\Tests\PresentationLayer;

use App\PresentationLayer\Model\Locale;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\LanguageRepository;
use App\Library\Http\Request\PaginatedRequest;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LocaleEntryPoint;
use App\PresentationLayer\Model\Language;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use Library\Util\Util;
use Symfony\Component\HttpFoundation\Response;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language as LanguageDataSource;

class LanguageEntryPointTest extends BasicSetup
{
    public function test_language_create()
    {
        $languageRepository = $this->locator->get(LanguageRepository::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);

        /** @var Locale $localeModel */
        $localeModel = $this->createLocale();

        /** @var Language $languageModel */
        $languageModel = $presentationModelDataProvider->getLanguageModel(
            $presentationModelDataProvider->getImageModel(),
            $localeModel
        );
        /** @var LanguageEntryPoint $languageEntryPoint */
        $languageEntryPoint = $this->locator->get(LanguageEntryPoint::class);

        /** @var Response $response */
        $response = $languageEntryPoint->create($languageModel);

        static::assertInstanceOf(Response::class, $response);
        static::assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getContent(), true)['resource']['data'];

        static::assertInternalType('int', $data['id']);
        static::assertNotEmpty($data['name']);
        static::assertInternalType('bool', $data['showOnPage']);
        static::assertNotEmpty($data['description']);
        static::assertInternalType('array', $data['image']);
        static::assertNotEmpty($data['image']);
        static::assertTrue(Util::isValidDate($data['createdAt']));
        static::assertNull($data['updatedAt']);

        $image = $data['image'];

        static::assertInternalType('int', $image['id']);
        static::assertNotEmpty($image['name']);
        static::assertNotEmpty($image['relativePath']);
        static::assertTrue(Util::isValidDate($image['createdAt']));
        static::assertNull($image['updatedAt']);

        $createdLanguage = $languageRepository->findOneBy([
            'name' => $data['name'],
        ]);

        static::assertInstanceOf(LanguageDataSource::class, $createdLanguage);
    }

    public function test_existing_language_fail()
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);

        /** @var LocaleEntryPoint $localeEntryPoint */
        $localeEntryPoint = $this->locator->get(LocaleEntryPoint::class);

        /** @var Locale $localeModel */
        $localeModel = $presentationModelDataProvider->getLocaleModel([
            'name' => 'en',
        ]);

        $localeEntryPoint->create($localeModel);

        /** @var Language $languageModel */
        $languageModel = $presentationModelDataProvider->getLanguageModel(
            $presentationModelDataProvider->getImageModel(),
            $localeModel
        );

        /** @var LanguageEntryPoint $languageEntryPoint */
        $languageEntryPoint = $this->locator->get(LanguageEntryPoint::class);

        /** @var Response $response */
        $response = $languageEntryPoint->create($languageModel);

        $data = json_decode($response->getContent(), true)['resource']['data'];

        static::assertInternalType('int', $data['id']);
        static::assertNotEmpty($data['name']);
        static::assertInternalType('bool', $data['showOnPage']);
        static::assertNotEmpty($data['description']);
        static::assertInternalType('array', $data['image']);
        static::assertNotEmpty($data['image']);
        static::assertTrue(Util::isValidDate($data['createdAt']));
        static::assertNull($data['updatedAt']);

        $image = $data['image'];

        static::assertInternalType('int', $image['id']);
        static::assertNotEmpty($image['name']);
        static::assertNotEmpty($image['relativePath']);
        static::assertTrue(Util::isValidDate($image['createdAt']));
        static::assertNull($image['updatedAt']);

        $existingLanguageException = false;

        try {
            $languageEntryPoint->create($languageModel);
        } catch (\RuntimeException $e) {
            $existingLanguageException = true;
        }

        static::assertTrue($existingLanguageException);
    }

    public function test_fail_language_create()
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);
        /** @var ModelValidator $deserializer */
        $modelValidator = $this->locator->get(ModelValidator::class);

        /** @var Language $languageModel */
        $languageModel = $presentationModelDataProvider->getInvalidLanguageModel();

        $enteredException = false;
        try {
            $modelValidator->validate($languageModel);
        } catch (\RuntimeException $e) {
            $enteredException = true;
        }

        static::assertTrue($enteredException);
    }

    public function test_get_languages()
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);
        /** @var LocaleEntryPoint $localeEntryPoint */
        $localeEntryPoint = $this->locator->get(LocaleEntryPoint::class);

        /** @var Locale $localeModel */
        $localeModel = $presentationModelDataProvider->getLocaleModel([
            'name' => 'en',
        ]);

        $localeEntryPoint->create($localeModel);

        $langNum = 10;
        $this->createLanguages($langNum, $localeModel);

        /** @var LanguageEntryPoint $languageEntryPoint */
        $languageEntryPoint = $this->locator->get(LanguageEntryPoint::class);

        $limit = 0;
        for ($i = 0; $i < $langNum; $i++) {
            $paginatedRequest = new PaginatedRequest(
                0,
                $limit
            );

            $languages = $languageEntryPoint->getLanguages($paginatedRequest);

            static::assertInstanceOf(Response::class, $languages);
            static::assertEquals(200, $languages->getStatusCode());

            static::assertInstanceOf(Response::class, $languages);

            $responseData = json_decode($languages->getContent(), true)['collection']['data'];

            static::assertEquals(count($responseData), $limit);

            foreach ($responseData as $data) {
                static::assertInternalType('int', $data['id']);
                static::assertNotEmpty($data['name']);
                static::assertInternalType('bool', $data['showOnPage']);
                static::assertNotEmpty($data['description']);
                static::assertInternalType('array', $data['image']);
                static::assertNotEmpty($data['image']);
                static::assertTrue(Util::isValidDate($data['createdAt']));
                static::assertNull($data['updatedAt']);

                $image = $data['image'];

                static::assertInternalType('int', $image['id']);
                static::assertNotEmpty($image['name']);
                static::assertNotEmpty($image['relativePath']);
                static::assertTrue(Util::isValidDate($image['createdAt']));
                static::assertNull($image['updatedAt']);
            }

            $limit++;
        }
    }
    /**
     * @param string $name
     * @return Locale
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLocale(string $name = 'en'): Locale
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);

        /** @var LocaleEntryPoint $localeEntryPoint */
        $localeEntryPoint = $this->locator->get(LocaleEntryPoint::class);
        /** @var Locale $localeModel */
        $localeModel = $presentationModelDataProvider->getLocaleModel([
            'name' => $name,
        ]);

        $response = $localeEntryPoint->create($localeModel);

        $data = json_decode($response->getContent(), true)['resource']['data'];

        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = $this->locator->get(SerializerWrapper::class);
        /** @var Locale $localeModel */
        $localeModel = $serializerWrapper->deserialize($data, Locale::class);

        return $localeModel;
    }
    /**
     * @param int $langNum
     * @param Locale $locale
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLanguages(
        int $langNum,
        Locale $locale
    ) {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);

        for ($i = 0; $i < $langNum; $i++) {
            /** @var Language $languageModel */
            $languageModel = $presentationModelDataProvider->getLanguageModel(
                $presentationModelDataProvider->getImageModel(),
                $locale
            );

            /** @var LanguageEntryPoint $languageEntryPoint */
            $languageEntryPoint = $this->locator->get(LanguageEntryPoint::class);

            $languageEntryPoint->create($languageModel);
        }
    }
}