<?php

namespace App\PresentationLayer\Infrastructure\Model;

class User implements PresentationModelInterface
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var string $lastname
     */
    private $lastname;
    /**
     * @var string $username
     */
    private $username;
    /**
     * @var string $email
     */
    private $email;
    /**
     * @var string $password
     */
    private $password;
    /**
     * @var bool $enabled
     */
    private $enabled = false;
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }
    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}