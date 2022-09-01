<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Chamada da api Imobiliaria
 */
require_once("ControllerApiBase.php");
class ControllerApiFolhaPagamento extends ControllerApiBase {
    
    public function index(Request $request, Response $response, array $args) {
        return $response->withJson(json_decode($this->getLocalizacoes()), 200);
    }
    
    public function getFolhas() {
        return '[
            {"data":"01/01/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/02/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/03/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/04/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/05/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/06/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/07/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/08/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/09/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/10/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/11/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/12/2021","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/01/2022","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/02/2022","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/03/2022","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/04/2022","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/05/2022","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/06/2022","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/07/2022","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"},
            {"data":"01/08/2022","tipo": "Folha Mensal", "competencia":"01/02/2022","provento":"1954,78","desconto":"154,76","liquido":"1654,78"}
        ]';
        
    }
}