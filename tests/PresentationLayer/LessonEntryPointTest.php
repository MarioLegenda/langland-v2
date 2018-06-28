<?php

namespace App\Tests\PresentationLayer;

use App\DataSourceLayer\Infrastructure\Doctrine\Repository\LessonRepository;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LessonEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LocaleEntryPoint;
use App\PresentationLayer\Model\Language;
use App\PresentationLayer\Model\Locale;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use App\PresentationLayer\Model\Lesson as LessonPresentationModel;
use Library\Infrastructure\Helper\SerializerWrapper;
use Library\Util\Util;
use Symfony\Component\HttpFoundation\Response;

class LessonEntryPointTest extends BasicSetup
{
    public function test_lesson_create_success()
    {
        /** @var LessonEntryPoint $lessonEntryPoint */
        $lessonEntryPoint = static::$container->get(LessonEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);
        /** @var Locale $localeModel */
        $localeModel = $this->createLocale();

        /** @var LessonPresentationModel $lessonPresentationModel */
        $lessonPresentationModel = $presentationModelDataProvider->getLessonModel(
            $this->createLanguage($localeModel),
            $localeModel
        );

        $response = $lessonEntryPoint->create($lessonPresentationModel);

        static::assertInstanceOf(Response::class, $response);
        static::assertEquals(201, $response->getStatusCode());

        static::assertInstanceOf(Response::class, $response);

        $responseData = json_decode($response->getContent(), true)['resource']['data'];

        static::assertInternalType('int', $responseData['id']);
        static::assertInternalType('string', $responseData['name']);
        static::assertNotEmpty($responseData['name']);
        static::assertInternalType('string', $responseData['temporaryText']);
        static::assertNotEmpty($responseData['temporaryText']);
        static::assertInternalType('string', $responseData['locale']);
        static::assertNotEmpty($responseData['locale']);
        static::assertInternalType('string', $responseData['locale']);
        static::assertNotEmpty($responseData['locale']);

        static::assertTrue(Util::isValidDate($responseData['createdAt']));
        static::assertNull($responseData['updatedAt']);
        /** @var LessonRepository $lessonRepository */
        $lessonRepository = $this->locator->get(LessonRepository::class);

        $lessonRepository->findOneBy([
            'name' => $lessonPresentationModel->getName(),
            'locale' => $lessonPresentationModel->getLocale(),
        ]);
    }
    /**
     * @param Locale $locale
     * @return Language
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLanguage(Locale $locale = null): Language
    {
        if (!$locale instanceof Locale) {
            $locale = $this->createLocale();
        }

        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = static::$container->get(SerializerWrapper::class);
        /** @var PresentationModelDataProvider $presentationLayerDataProvider */
        $presentationLayerDataProvider = static::$container->get(PresentationModelDataProvider::class);

        /** @var Language $languageModel */
        $languageModel = $presentationLayerDataProvider->getLanguageModel(
            $presentationLayerDataProvider->getImageModel(),
            $locale
        );

        /** @var LanguageEntryPoint $languageEntryPoint */
        $languageEntryPoint = $this->locator->get(LanguageEntryPoint::class);

        $data = json_decode($languageEntryPoint->create($languageModel)->getContent(), true);

        /** @var Language $newLanguage */
        $newLanguage = $serializerWrapper->deserialize($data['resource']['data'], Language::class);

        return $newLanguage;
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
            'default' => true,
        ]);

        $response = $localeEntryPoint->create($localeModel);

        $data = json_decode($response->getContent(), true)['resource']['data'];

        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = $this->locator->get(SerializerWrapper::class);
        /** @var Locale $localeModel */
        $localeModel = $serializerWrapper->deserialize($data, Locale::class);

        return $localeModel;
    }
}