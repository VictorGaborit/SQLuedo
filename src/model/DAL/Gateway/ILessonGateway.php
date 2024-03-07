<?php

namespace Model\DAL\Gateway;

interface ILessonGateway
{
    /**
     * @return array
     */
    public function loadlLessons(): array;

    /**
     * @param int $id
     * @return array
     */
    public function getLesson(int $id): array;

    /**
     * @param int $id
     * @return array
     */
    public function getContentLesson(int $id): array;
}
