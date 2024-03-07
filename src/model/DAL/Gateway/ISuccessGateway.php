<?php

namespace Model\DAL\Gateway;

interface ISuccessGateway
{
    /**
     * @param int $idUser
     * @return array
     */
    public function loadSuccess(int $idUser): array;

    /**
     * @return array
     */
    public function findById(): array;
}
