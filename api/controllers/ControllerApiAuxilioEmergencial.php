<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Chamada da api Usuario
 *
 * User: Gelvazio Camargo
 * Date: 11/08/2022
 * Time: 21:50:00
 */
require_once("ControllerApiBase.php");
class ControllerApiAuxilioEmergencial extends ControllerApiBase
{

    public function getAuxilios(Request $request, /*@var $response MessageInterface */ Response $response, array $args)
    {
        $sSql = "SELECT * FROM auxilioemergencial ORDER BY 1";

        $aDados = $this->getQuery()->selectAll($sSql);

        return $response->withJson($aDados, 200);
    }
}
