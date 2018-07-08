<?php

namespace App\Infrastructure\Machine;

class QuestionTypes
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
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->answers);
    }
}