<?php

namespace Model\ClassMetier;

class User
{
    private string $username;
    private string $password;
    private string $email;
    private int $id;
    private bool $isAdmin;

    /**
     * @param int $id
     * @param bool $isAdmin
     * @param string $username
     * @param string $password
     * @param string $email
     */
    public function __construct(bool $isAdmin, string $username, string $password, string $email, int $id = -1)
    {
        $this->isAdmin = $isAdmin;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function isAdmin(): int
    {
        if ($this->isAdmin) {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
