<?php

namespace Model\ClassMetier;

class Inquiry
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $title;
    /**
     * @var string
     */
    private string $description;
    /**
     * @var bool
     */
    private bool $isUser;

    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param bool|string $isUser
     */
    public function __construct(int $id, string $title, string $description, bool $isUser)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->isUser = $isUser;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function getIsUser(): bool
    {
        return $this->isUser;
    }

    /**
     * @param bool $isUser
     * @return void
     */
    public function setIsUser(bool $isUser): void
    {
        $this->isUser = $isUser;
    }
}
