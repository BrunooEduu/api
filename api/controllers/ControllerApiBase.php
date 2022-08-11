<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Contem os metodos base de chamada da api que são chamados em mais de uma rota.
 *
 * User: Gelvazio Camargo
 * Date: 10/12/2020
 * Time: 17:40
 */
require_once("core/Query.php");
class ControllerApiBase {

    public function callPing(Request $request, Response $response, array $args) {
        $data = array("data" => date("Y-m-d H:i:s"));
        return $response->withJson($data, 200);
    }

    /**
     *
     * @var ModelPadrao
     */
    protected $Model;

    /**
     *
     * @var Query
     */
    private $Query;

    public function getQuery() {
        if (!isset($this->Query)) {
            $this->Query = new Query();
        }
        return $this->Query;
    }

    public function setQuery(Query $Query) {
        $this->Query = $Query;
    }

    public function getModel() {
        return $this->Model;
    }

    public function setModel(ModelPadrao $Model) {
        $this->Model = $Model;
    }
}