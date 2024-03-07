<?php

namespace Model\DAL\Gateway;

use Model\ClassMetier\User;

interface IUserGateway
{
    /**
     * @param string $username
     * @return array
     */
    public function findByUsername(string $username): array;

    /**
     * @param int $id
     * @return array
     */
    public function findById(int $id): array;

    /**
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email): ?array;

    /**
     * @param int $id
     * @param string $username
     * @param string $email
     * @return mixed
     */
    public function updateById(int $id, string $username, string $email);

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteById(int $id);

    /**
     * @param User $user
     * @return mixed
     */
    public function insertNewUser(User $user);

    /**
     * @param string $email
     * @return array|null
     */
    public function findBanByEmail(string $email): ?array;
}
