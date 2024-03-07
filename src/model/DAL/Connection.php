<?php

namespace Model\DAL;

use PDO;

class Connection extends PDO
{

    private $stmt;

    /**
     * @param string $dsn
     * @param string $username
     * @param string $password
     */
    public function __construct(string $dsn, string $username, string $password)
    {
        parent::__construct($dsn, $username, $password);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Summary : Permet d'exécuter une requête SQL avec l'aide de la classe PDO.
     * @param string $query
     * @param array $parameters
     * @return bool Returns `true` on success, `false` otherwise
     */

    public function executeQuery(string $query, array $parameters = []): bool
    {
        $this->stmt = parent::prepare($query);
        foreach ($parameters as $name => $value) {
            $this->stmt->bindValue($name, $value[0], $value[1]);
        }
        return $this->stmt->execute();
    }

    /**
     * Summary : Permet de récupérer le résultat de la dernière requête exécutée.
     * @return array
     */
    public function getResults(): array
    {
        return $this->stmt->fetchall(PDO::FETCH_ASSOC);
    }
}
