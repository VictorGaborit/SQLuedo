<?php

namespace Model\DAL\Gateway;

use Model\DAL\Connection;
use PDO;

class MySQLGameGateway implements IGameGateway
{
    private $inquiryId;
    private $pdo;
    private $base;

    /**
     * @param $inquiryId
     * @param $base
     */
    public function __construct($inquiryId, $base)
    {
        global $userPlayer, $passwordPlayer, $dsnPlayer;
        $dsn = $dsnPlayer . $base;
        $this->inquiryId = $inquiryId;
        $this->base = $base;
        $this->pdo = new Connection($dsn, $userPlayer, $passwordPlayer);
        $this->manageAccessRights();
    }

    /**
     * @return void
     */
    public function manageAccessRights() : void
    {
        global $userPlayer, $user, $password, $dsn;
        $con = new Connection($dsn, $user, $password);
        $query = 'REVOKE ALL PRIVILEGES ON *.* FROM :user';
        $con->executeQuery($query, array(':user' => array($userPlayer, PDO::PARAM_STR)));
        $query = 'GRANT SELECT ON ' . $this->base . '.* TO :user';
        $con->executeQuery($query, array(':user' => array($userPlayer, PDO::PARAM_STR)));
    }

    /**
     * @param $request
     * @return void
     */
    public function executeQuery($request): void
    {
        $query = 'USE ' . $this->base;
        $this->pdo->executeQuery($query);
        $this->pdo->executeQuery($request);
    }

    /**
     * @return array
     */
    public function getResults(): array
    {
        return $this->pdo->getResults();
    }
}
