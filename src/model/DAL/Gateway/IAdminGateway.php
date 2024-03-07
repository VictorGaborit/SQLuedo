<?php

namespace Model\DAL\Gateway;

interface IAdminGateway
{
    /**
     * @param int $nbUser
     * @param int $numeroPage
     * @return array
     */
    public function printUsersList(int $nbUser, int $numeroPage): array;

    /**
     * @param int $nbUser
     * @param int $decalage
     * @return array
     */
    public function printUsersListBan(int $nbUser, int $decalage): array;

    /**
     * @param string $username
     * @return void
     */
    public function promoteUser(string $username): void;

    /**
     * @param string $username
     * @return void
     */
    public function deleteByUsername(string $username): void;

    /**
     * @param string $username
     * @return void
     */
    public function banUser(string $username): void;

    /**
     * @param string $email
     * @return void
     */
    public function unbanUser(string $email): void;
}
