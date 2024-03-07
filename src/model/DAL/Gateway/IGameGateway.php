<?php

namespace Model\DAL\Gateway;

interface IGameGateway
{
    /**
     * @param $request
     * @return mixed
     */
    public function executeQuery($request);

    /**
     * @return array
     */
    public function getResults(): array;

    /**
     * @return mixed
     */
    public function manageAccessRights();
}
