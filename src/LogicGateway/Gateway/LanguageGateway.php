<?php

namespace App\LogicGateway\Gateway;

use App\DataSourceLayer\RepositoryFactory;
use App\DataSourceLayer\Type\MysqlType;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Language;
use App\LogicLayer\LogicInterface;
use App\LogicLayer\LearningMetadata\Logic\LanguageLogic;
use App\PresentationLayer\Model\PresentationModelInterface;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\DataSourceLayer\Doctrine\Entity\Language as LanguageDataSource;

use App\DataSourceLayer\Doctrine\Entity\Language as DataSourceModel;

class LanguageGateway
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var LogicInterface|LanguageLogic
     */
    private $logic;

    /**
     * LanguageGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param LogicInterface $logic
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        LogicInterface $logic
    ) {
        $this->logic = $logic;
        $this->serializerWrapper = $serializerWrapper;
    }
    /**
     * @param PresentationModelInterface $model
     */
    public function create(PresentationModelInterface $model): void
    {
        /** @var DomainModelInterface $logicModel */
        $logicModel = $this->serializerWrapper
            ->convertFromToByGroup($model, 'default', Language::class);

        /** @var DomainModelInterface $domainLogicModel */
        $domainLogicModel = $this->logic->create($logicModel);

        $dataSourceModel = $this->serializerWrapper
            ->convertFromToByGroup($domainLogicModel, 'default', LanguageDataSource::class);

        RepositoryFactory::create(DataSourceModel::class, MysqlType::fromValue())->save($dataSourceModel);
    }
}