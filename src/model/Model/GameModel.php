<?php

namespace Model\Model;

use Model\DAL\Gateway\IGameGateway;

class GameModel
{
    private IGameGateway $gateway;

    /**
     * @param $gateway
     */
    public function __construct($gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @param $query
     * @return void
     */
    public function executeQuery($query)
    {
        $this->gateway->executeQuery($query);
    }

    /**
     * @return array
     */
    public function getResults(): array
    {
        return $this->gateway->getResults();
    }
}
