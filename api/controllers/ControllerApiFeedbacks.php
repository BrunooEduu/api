<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Chamada da api Atividades
 */
require_once("ControllerApiBase.php");
class ControllerApiFeedbacks extends ControllerApiBase {

    public function index(Request $request, Response $response, array $args) {
        $body = $request->getParsedBody();
    
        $aDados = array();
            
        $token_logado = $body["token_logado"];
        if($token_logado){
            $id          = isset($body["id"]) ? $body["id"] : false;        
            $usucodigo   = isset($body["usucodigo"]) ? $body["usucodigo"] : false;
            $idatividade = isset($body["idatividade"]) ? $body["idatividade"] : false;            
            
            $aDados = $this->getListAll($id, $usucodigo, $idatividade, true);
        }
        
        
        return $response->withJson($aDados, 200);
    }
    
    private function getListAll($id = false, $usucodigo = false, $idatividade = false, $bIndex = false){
        $condicao = " where 1 = 1 ";
        if($usucodigo){
            $condicao .= " and usucodigo = $usucodigo";
        }
        if($idatividade){
            $condicao .= " and idatividade = $idatividade";
        }
        if($id){
            $condicao .= " and id = $id";
        }        
    
        // Usuario 1 - Admim, lista tudo
        if($bIndex && $usucodigo == 1){
            $condicao = "";
        }
        
        $sSql = "SELECT * FROM feedback $condicao ORDER BY 1";
    
        return $this->getQuery()->selectAll($sSql);
    }
    
    public function store(Request $request, Response $response, array $args) {    
        $body = $request->getParsedBody();
        
        $usucodigo = isset($body["usucodigo"]) ? $body["usucodigo"] : false;
        $idatividade = $body["idatividade"];
        $descricaofeedback = $body["descricaofeedback"];    
        
        $aDados = $this->gravaDadosBanco($idatividade, $descricaofeedback, $usucodigo);
        
        return $response->withJson($aDados, 200);
    }    
    
    public function update(Request $request, Response $response, array $args) {    
        $body = $request->getParsedBody();
        $aDados = array();
        $id = $body["id"];
        $descricaofeedback = $body["descricaofeedback"];
    
        $aDadosFeedback = $this->getListAll($id);
    
        // Se ja tiver um feedback, retorna o mesmo
        if(count($aDadosFeedback)){
            $aDados = $this->updateDadosBanco($id, $descricaofeedback);            
        }
        
        return $response->withJson($aDados, 200);
    }
    
    private function updateDadosBanco($id, $descricaofeedback){
    
        $sql_update = " update feedback set feedback = '$descricaofeedback' 
                         where id = $id";
        $aDadosFeedback = array();
        if($this->getQuery()->executaQuery($sql_update)){
            // busca os dados atualizados do banco
            $aDadosFeedback = $this->getListAll($id);
        }
        
        return $aDadosFeedback;
    }
    
    private function gravaDadosBanco($idatividade, $descricaofeedback, $usucodigo = false){
        if((int)$usucodigo > 0){
            $aDadosFeedback = $this->insereAtividadePorUsuario($idatividade, $descricaofeedback, $usucodigo);            
        } else {
            // insere atividade para todos os usuarios
            $aListaUsuarios = $this->getQuery()->selectAll("select * from usuario order by usucodigo");
            
            $aDadosFeedback = array();
            
            foreach ($aListaUsuarios as $usucodigoAtividade){
                $this->insereAtividadePorUsuario($idatividade, $descricaofeedback, $usucodigoAtividade);
                
                $aDadosFeedback = $this->getListAll(false, $usucodigoAtividade, $idatividade);
            }
    
            if(count($aDadosFeedback)){
                $aDadosFeedback = $aDadosFeedback[0];
            }            
        }        
        
        return $aDadosFeedback;
    }
    
    public function insereAtividadePorUsuario($idatividade, $descricaofeedback, $usucodigo) {
        $aDadosFeedback = array();
        
        if((int)$usucodigo > 0 && (int)$idatividade > 0 && $descricaofeedback != ""){
            $aDadosFeedback = $this->getListAll(false, $usucodigo, $idatividade);
        
            // Se ja tiver um feedback, retorna o mesmo
            if(count($aDadosFeedback)){
                return $aDadosFeedback[0];
            }
        
            $sql_insert = 'insert into feedback(usucodigo, idatividade, feedback) values ( 
              ' . $usucodigo . ',
              ' . $idatividade . ',
              \'' . $descricaofeedback . '\'
            );';
        
            if($this->getQuery()->executaQuery($sql_insert)){
                $sql = "select * from feedback order by 1 desc limit 1";
            
                if($aDados = $this->getQuery()->selectAll($sql)){
                    $aDadosFeedback = $aDados[0];
                }
            }
        }
        
        return $aDadosFeedback;
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