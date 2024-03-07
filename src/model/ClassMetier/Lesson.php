<?php

namespace Model\ClassMetier;

/**
 *
 */
class Lesson
{
    private string $lastEdit;
    private string $lastPublisher;
    private array $content;
    private string $title;
    private int $id;


    /**
     * @param string $title
     * @param string|null $lastEdit
     * @param string|null $lastPublisher
     * @param array|null $content
     * @param int $id
     */

    public function __construct(string $title,
                                string $lastEdit = null,
                                string $lastPublisher = null,
                                array  $content = null,
                                int    $id = -1
                                )
    {
        $this->title = $title;
        $this->lastEdit = $lastEdit ?? date('l jS \of F Y h:i:s A');
        $this->lastPublisher = $lastPublisher ?? "Unknown";
        $this->content = $content ?? array();
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastEdit(): string
    {
        return $this->lastEdit;
    }

    /**
     * @return string
     */
    public function getLastPublisher(): string
    {
        return $this->lastPublisher;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * @param array $content
     * @return void
     */
    public function setContent(array $content): void
    {
        $this->content = $content;
    }
}
