<?php

namespace Model\Factory;

interface IFactory
{
    /**
     * @param array $data
     * @return array
     */
    public function createObject(array $data): array;
}
