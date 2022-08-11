<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Chamada da api Pessoa.
 *
 * User: Gelvazio Camargo
 * Date: 10/12/2020
 * Time: 17:40
 */
require_once("ControllerApiBase.php");
class ControllerApiPessoa extends ControllerApiBase {

    public function getPessoa(Request $request, Response $response, array $args) {
        $sSql = "SELECT * FROM pessoa ORDER BY cd_pessoa";
        $aDados = $this->getQuery()->selectAll($sSql);
        return $response->withJson($aDados, 200);
    }

    public function getConsultaPessoa(Request $request, Response $response, array $args) {
        $sSql = "SELECT * FROM pessoa ORDER BY pescodigo";
        $aDados = $this->getQuery()->selectAll($sSql);
        return $response->withJson($aDados, 200);
    }
}