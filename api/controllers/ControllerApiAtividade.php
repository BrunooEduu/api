<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Chamada da api Atividades
 */
require_once("ControllerApiBase.php");
class ControllerApiAtividade extends ControllerApiBase {

    public function getAtividades(Request $request, Response $response, array $args) {
        $sSql = "SELECT * FROM atividade ORDER BY 1";
        
        $aDados = $this->getQuery()->selectAll($sSql);
        
        return $response->withJson($aDados, 200);
    }
    
    public function gravaAtividades(Request $request, Response $response, array $args) {    
        $body = $request->getParsedBody();
        
        $descricaoAtividade = $body["descricaoAtividade"];
        $dataAtividade = isset($body["data"]) ? $body["data"] : false;
    
        $aDadosAtividade = $this->gravaAtividadeBanco($descricaoAtividade, $dataAtividade);
        
        return $response->withJson($aDadosAtividade, 200);
    }
    
    private function gravaAtividadeBanco($descricaoAtividade, $data = false){
        if(!$data){
            $data = date("Y-m-d");            
        }
        
        $sql_insert = 'insert into atividade(data, status, atividade) values ( 
          \'' . $data . '\',
          \'status_not_verified\',
          \'' . $descricaoAtividade . '\'
        );';
        
        if($this->getQuery()->executaQuery($sql_insert)){
            $sql = "select * from atividade order by 1 desc limit 1";
    
            if($aDados = $this->getQuery()->selectAll($sql)){
                return $aDados[0];
            }
        }
        
        return array();
    }
      
}