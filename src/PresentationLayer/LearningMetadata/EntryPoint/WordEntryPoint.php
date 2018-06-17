<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use App\LogicGateway\Gateway\WordGateway;
use App\PresentationLayer\Model\Word\Word;

class WordEntryPoint
{
    /**
     * @var WordGateway
     */
    private $wordGateway;
    /**
     * WordEntryPoint constructor.
     * @param WordGateway $wordGateway
     */
    public function __construct(
        WordGateway $wordGateway
    ) {
        $this->wordGateway = $wordGateway;
    }
    /**
     * @param Word $word
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(Word $word)
    {
        $this->wordGateway->create($word);
    }
}