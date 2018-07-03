<?php

namespace App\Web\LearningMetadata;

use App\PresentationLayer\Infrastructure\Model\Language;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;

class LanguageController
{
    /**
     * @var LanguageEntryPoint $languageEntryPoint
     */
    private $languageEntryPoint;
    /**
     * LanguageController constructor.
     * @param LanguageEntryPoint $languageEntryPoint
     */
    public function __construct(
        LanguageEntryPoint $languageEntryPoint
    ) {
        $this->languageEntryPoint = $languageEntryPoint;
    }
    /**
     * @param Language $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Language $user)
    {
        $this->languageEntryPoint->create($user);
    }
}