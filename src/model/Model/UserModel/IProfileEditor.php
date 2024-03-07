<?php

namespace Model\Model\UserModel;

interface IProfileEditor
{
    /**
     * @param string $username
     * @param string $email
     * @return void
     */
    public function editProfile(string $username, string $email): void;
}
