<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use App\LogicGateway\Gateway\LanguageGateway;
use App\PresentationLayer\Model\Language as LanguageModel;
use App\PresentationLayer\Model\PresentationModelInterface;

class Language
{
    /**
     * @param LanguageModel|PresentationModelInterface $language
     * @param LanguageGateway $languageGateway
     */
    public function create(LanguageModel $language, LanguageGateway $languageGateway)
    {
        $logicModel = $languageGateway->create($language);

        dump($logicModel);
    }
}