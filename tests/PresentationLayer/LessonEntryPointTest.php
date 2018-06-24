<?php

namespace App\Tests\PresentationLayer;

use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LessonEntryPoint;
use App\PresentationLayer\Model\Language;
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

        /** @var LessonPresentationModel $lessonPresentationModel */
        $lessonPresentationModel = $presentationModelDataProvider->getLessonModel(
            $this->createLanguage()
        );

        $response = $lessonEntryPoint->create($lessonPresentationModel);

        static::assertInstanceOf(Response::class, $response);

        $responseData = json_decode($response->getContent(), true)['resource']['data'];

        static::assertInternalType('int', $responseData['id']);
        static::assertInternalType('string', $responseData['name']);
        static::assertNotEmpty($responseData['name']);
        static::assertInternalType('string', $responseData['temporaryText']);
        static::assertNotEmpty($responseData['temporaryText']);

        static::assertTrue(Util::isValidDate($responseData['createdAt']));
        static::assertNull($responseData['updatedAt']);
    }
    /**
     * @return Language
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLanguage(): Language
    {
        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = static::$container->get(SerializerWrapper::class);
        /** @var PresentationModelDataProvider $presentationLayerDataProvider */
        $presentationLayerDataProvider = static::$container->get(PresentationModelDataProvider::class);
        /** @var Language $languageModel */
        $languageModel = $presentationLayerDataProvider->getLanguageModel(
            $presentationLayerDataProvider->getImageModel()
        );

        /** @var LanguageEntryPoint $languageEntryPoint */
        $languageEntryPoint = $this->locator->get(LanguageEntryPoint::class);

        $data = json_decode($languageEntryPoint->create($languageModel)->getContent(), true);

        /** @var Language $newLanguage */
        $newLanguage = $serializerWrapper->deserialize($data['resource']['data'], Language::class);

        return $newLanguage;
    }
}