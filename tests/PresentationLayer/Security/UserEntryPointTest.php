<?php

namespace App\Tests\PresentationLayer\Security;

use App\PresentationLayer\Infrastructure\Model\Locale;
use App\PresentationLayer\LearningMetadata\EntryPoint\LocaleEntryPoint;
use App\PresentationLayer\Security\EntryPoint\UserEntryPoint;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Library\Infrastructure\Helper\SerializerWrapper;

class UserEntryPointTest extends BasicSetup
{
    public function test_user_create_success()
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);
        /** @var UserEntryPoint $userEntryPoint */
        $userEntryPoint = $this->locator->get(UserEntryPoint::class);

        $locale = $this->createLocale();

        $user = $presentationModelDataProvider->getUserModel($locale);

        $userEntryPoint->create($user);
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