<?php

namespace Model\ClassMetier;

class Paragraph extends ContentLesson
{
    private string $info;
    private string $query;
    private string $comment;

    /**
     * @param string $title
     * @param string $content
     * @param string $info
     * @param string $query
     * @param string $comment
     */
    public function __construct(string $title, string $content, string $info, string $query, string $comment)
    {
        parent::__construct($title, $content);
        $this->info = $info;
        $this->query = $query;
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return $this->info;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }
}
