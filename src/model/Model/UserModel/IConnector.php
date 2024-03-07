<?php

namespace Model\Model\UserModel;

interface IConnector
{
    /**
     * @return bool
     */
    public static function logout(): bool;

    /**
     * @return bool
     */
    public function isConnected(): bool;

    /**
     * @return bool
     */
    public function login(): bool;

    /**
     * @return bool
     */
    public function registration(): bool;

    /**
     * @param string $message
     * @return void
     */
    public function redirectRegistrationToError(string $message): void;

    /**
     * @param string $message
     * @return void
     */
    public function redirectLoginToError(string $message): void;
}
