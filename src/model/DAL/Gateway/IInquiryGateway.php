<?php

namespace Model\DAL\Gateway;

interface IInquiryGateway
{
    /**
     * @return array
     */
    public function loadInquiry(): array;

    /**
     * @param int $id
     * @return array
     */
    public function findById(int $id): array;
}
