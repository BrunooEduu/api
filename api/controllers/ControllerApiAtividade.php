<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Chamada da api Atividades
 */
require_once("ControllerApiBase.php");
class ControllerApiAtividade extends ControllerApiBase {

    public function getAtividades(Request $request, Response $response, array $args) {
        $body = $request->getParsedBody();
        
        $id = isset($body["id"]) ? $body["id"] : false;
    
        $aDados = $this->getListaAtividades($id);
        
        return $response->withJson($aDados, 200);
    }
    
    private function getListaAtividades($id = false){
        $condicao = "";
        if($id){
            $condicao = " where id = $id";
        }
    
        $sSql = "SELECT * FROM atividade $condicao ORDER BY 1";
    
        return $this->getQuery()->selectAll($sSql);
    }
    
    public function gravaAtividades(Request $request, Response $response, array $args) {    
        $body = $request->getParsedBody();
        
        $descricaoAtividade = $body["descricaoAtividade"];
        $dataAtividade = isset($body["data"]) ? (int)$body["data"] : false;
    
        $aDadosAtividade = $this->gravaAtividadeBanco($descricaoAtividade, $dataAtividade);
        
        return $response->withJson($aDadosAtividade, 200);
    }
    
    private function gravaAtividadeBanco($descricaoAtividade, $data = false){
        if(!$data){
            $ano = (int)date("Y");
            $mes = (int)date("m");
            $dia = (int)date("d");
            
            if($mes < 10){
                $mes = '0' . $mes;
            }
            
            if($dia < 10){
                $dia = '0' . $dia;
            }            
            
            $data = (int) $ano . $mes . $dia;   
        }
        
        $sql_insert = 'insert into atividade(data, status, atividade) values ( 
          ' . $data . ',
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
    
    public function excluiAtividade(Request $request, Response $response, array $args) {
        $body = $request->getParsedBody();
        
        $id = isset($body["id"]) ? $body["id"] : false;
        $aDados = $this->getListaAtividades($id);
        
        if(count($aDados)){
            $this->getQuery()->executaQuery("delete from atividade where id = $id");
        }
        
        return $response->withJson(array("status" => true, "mensagem" => "Atividade excluida com sucesso!"), 200);
    }
      
}