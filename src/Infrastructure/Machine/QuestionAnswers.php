<?php

namespace App\Infrastructure\Machine;

use App\Infrastructure\Machine\Type\TypeList\FrontendTypeList;
use App\Infrastructure\Machine\Type\TypeInterface;

class QuestionAnswers implements \IteratorAggregate
{
    /**
     * @var array $answers
     */
    private $answers;
    /**
     * QuestionAnswers constructor.
     * @param array $answers
     */
    public function __construct(array $answers)
    {
        $this->answers = $answers;
    }
    /**
     * @return array
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @return TypeInterface[]
     */
    public function getAnswersAsTypes(): array
    {
        $typeList = FrontendTypeList::getList();

        $types = [];

        foreach ($this->answers as $typeName => $answer) {
            $types[] = $typeList[$typeName]::{'fromValue'}($answer);
        }

        return $types;
    }
    /**
     * @param string $typeName
     * @return TypeInterface
     */
    public function asType(string $typeName): TypeInterface
    {
        return FrontendTypeList::getList()[$typeName]::{'fromValue'}($this->answers[$typeName]);
    }
    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->answers);
    }
}