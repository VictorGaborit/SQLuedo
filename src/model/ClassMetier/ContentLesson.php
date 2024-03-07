<?php

namespace Model\ClassMetier;

abstract class ContentLesson
{
    protected string $contentTitle;
    protected string $contentContent;

    /**
     * @param string $title
     * @param string $content
     */
    public function __construct(string $title, string $content)
    {
        $this->contentTitle = $title;
        $this->contentContent = $content;
    }

    /**
     * @return string
     */
    public function getContentTitle(): string
    {
        return $this->contentTitle;
    }

    /**
     * @return string
     */
    public function getContentContent(): string
    {
        return $this->contentContent;
    }
}
