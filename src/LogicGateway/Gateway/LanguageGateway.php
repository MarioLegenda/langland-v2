<?php

namespace App\LogicGateway\Gateway;

use App\LogicGateway\Contract\Gateway;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Language;
use App\PresentationLayer\Model\PresentationModelInterface;

class LanguageGateway extends Gateway
{
    /**
     * @inheritdoc
     */
    public function create(PresentationModelInterface $model): DomainModelInterface
    {
        /** @var DomainModelInterface $logicModel */
        $logicModel = $this->serializerWrapper
            ->convertFromTo($model, 'default', Language::class);

        return $logicModel;
    }
}