<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use App\LogicGateway\Gateway\LanguageGateway;
use App\PresentationLayer\Model\Language as LanguageModel;
use App\PresentationLayer\Model\PresentationModelInterface;

class Language
{
    /**
     * @var LanguageGateway $languageGateway
     */
    private $languageGateway;
    /**
     * Language constructor.
     * @param LanguageGateway $languageGateway
     */
    public function __construct(
        LanguageGateway $languageGateway
    ) {
        $this->languageGateway = $languageGateway;
    }

    /**
     * @param LanguageModel|PresentationModelInterface $language
     */
    public function create(LanguageModel $language)
    {
        $logicModel = $this->languageGateway->create($language);

        dump($logicModel);
        die();
    }
}