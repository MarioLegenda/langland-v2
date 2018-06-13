<?php

namespace App\PresentationLayer\Model;

class Category implements PresentationModelInterface
{
    /**
     * @var string $name
     */
    private $name;
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}