<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Chamada da api Usuario
 *
 * User: Gelvazio Camargo
 * Date: 10/12/2020
 * Time: 17:40
 */
require_once("ControllerApiBase.php");
require_once ("./core/token.php");
require_once ("./model/Usuario.php");
class ControllerApiUsuario extends ControllerApiBase {

    public function getUsuario(Request $request, Response $response, array $args) {
        $body = $request->getParsedBody();
        $usucodigo = isset($body["usucodigo"]) ? $body["usucodigo"] : false;
        
        $sSql = "SELECT * FROM usuario where 1 = 2 ORDER BY 1";            
        if($usucodigo){
            $sSql = "SELECT * FROM usuario where usucodigo = $usucodigo ORDER BY 1";
            if($usucodigo == 1){
                $sSql = "SELECT * FROM usuario ORDER BY 1";
            }
        }
        
        $aDados = $this->getQuery()->selectAll($sSql);
        
        return $response->withJson($aDados, 200);
    }
    
    public function gravaUsuario(Request $request, Response $response, array $args) {
        require_once ("./core/token.php");        
        require_once ("./model/Usuario.php");
    
        $body = $request->getParsedBody();
        $oUsuario = new Usuario($body["usunome"],$body["usuemail"],$body["ususenha"],$body["usutoken"],$body["usuativo"]);
        // Se ja tiver um usuario com este email, retorna este usuario
        if($aDadosUsuario = $this->getUsuarioPorEmail($oUsuario->getUsuemail())){
            return $response->withJson($aDadosUsuario, 200);
        }
        
        $token = encodeToken($oUsuario);
        $oUsuario->setUsutoken($token);
        $oUsuario->setUsusenha(bcrypt($body["ususenha"]));
        
        $body["usutoken"] = $token;
        $body["UsuarioBanco"] = $this->gravaUsuarioBanco($oUsuario);;            
        
        return $response->withJson($body, 200);
    }
    
    private function gravaUsuarioBanco($oUsuario){
        // Se ja tiver um usuario com este email, retorna este usuario
        if($aDadosUsuario = $this->getUsuarioPorEmail($oUsuario->getUsuemail())){
            return $aDadosUsuario;
        }
        
        $sql_insert = 'insert into usuario(usunome,usuemail,ususenha,usutoken,usuativo) values ( 
          \'' . $oUsuario->getUsunome() . '\',
          \'' . $oUsuario->getUsuemail() . '\',
          \'' . $oUsuario->getUsusenha() . '\',
          \'' . $oUsuario->getUsutoken() . '\',
          ' . $oUsuario->getUsuativo() . '
        );';
        
        if($this->getQuery()->executaQuery($sql_insert)){
            return $this->getUsuarioPorEmail($oUsuario->getUsuemail());
        }
        
        return array();
    }
    
    private function getUsuarioPorEmail($email){
        $sql_usuario = "select * from usuario where usuemail = '" . $email . "' limit 1";
    
        if($aDados = $this->getQuery()->selectAll($sql_usuario)){
            return $aDados[0];
        }
        return false;
    }
    
    public function loginUsuario(Request $request, Response $response, array $args) {
        $body = $request->getParsedBody();
        
        $token_usuario = isset($body["token_logado"]) ? $body["token_logado"] : false;
        if($token_usuario){
            $dadosLogin = $this->loginComToken($token_usuario);            
        } else {
            $dadosLogin = $this->loginComSenha($body);
        }
        
        return $response->withJson(array("dadoslogin" => $dadosLogin), 200);        
    }
    
    private function loginComToken($token_logado){
        $aDadosUsuarioResponse = array();
        $aDadosUsuarioResponse["login"] = false;
        $aDadosUsuarioResponse["mensagem"] = "Usuario ou senha invalidos!";
        
        // verifica se e um token valido
        $aDadosToken = explode('.', $token_logado);
        if(count($aDadosToken) !== 3){
            return $aDadosUsuarioResponse;
        }
        
        // Decodifica o token do usuario
        $token_decode = decodeToken($token_logado);    
        $usuemail = $token_decode->usuemail;
        if($aDadosUsuario = $this->getUsuarioPorEmail($usuemail)) {
            if ($token_logado === $aDadosUsuario["usutoken"]) {
                $aDadosUsuarioResponse["mensagem"] = "Token validado com sucesso!";
                $aDadosUsuarioResponse["login"] = true;
            }            
        }     
        return $aDadosUsuarioResponse;
    }
    
    private function loginComSenha($body){
        $senha_informada = $body["ususenha"];
        $aDadosUsuarioResponse = array();
        $aDadosUsuarioResponse["login"] = false;
        $aDadosUsuarioResponse["mensagem"] = "Usuario ou senha invalidos!";
        if($aDadosUsuario = $this->getUsuarioPorEmail($body["usuemail"])) {
            $oUsuario = new Usuario($aDadosUsuario["usunome"],
                $aDadosUsuario["usuemail"],
                $aDadosUsuario["ususenha"],
                $aDadosUsuario["usutoken"],
                $aDadosUsuario["usuativo"]);
    
            $oUsuario->setUsucodigo($aDadosUsuario["usucodigo"]);
            
            // $api_key = "769E46AAD7AD1833E3174B6E88CCC-F373C6DC6367A967B242CA4CCDDA2";
        
            // Decodifica o token do usuario
            // $token_decode = decodeToken($oUsuario->getUsutoken(), $api_key);
        
            $senha_banco_dados = $aDadosUsuario["ususenha"];
            if (password_verify($senha_informada, $senha_banco_dados)) {
                $aDadosUsuario             = array();
                $aDadosUsuario["login"]    = true;
                $aDadosUsuario["token"]    = $oUsuario->getUsutoken();
                $aDadosUsuario["usucodigo"]= $oUsuario->getUsucodigo();
                $aDadosUsuario["usunome"]  = $oUsuario->getUsunome();
                $aDadosUsuario["usuemail"] = $oUsuario->getUsuemail();
                $aDadosUsuario["mensagem"] = "Usuario validado com sucesso!";
            
                $aDadosUsuarioResponse = $aDadosUsuario;
            }
        }
    
        return $aDadosUsuarioResponse;
    }
    
    public function updatePassword(Request $request, Response $response, array $args) {
        $body = $request->getParsedBody();
        $oUsuario = $this->loginComSenha($body);
    
        $aDados = array("status" => false, "mensagem" => "Erro ao alterar senha...");
        if($oUsuario && $oUsuario["login"]){
            $usucodigo = (int)$oUsuario["usucodigo"];
            if($oModelUsuario = $this->updateDadosBanco($usucodigo, $body["ususenha_nova"])){
                $aDados = array("status" => true, "Usuario" => $oModelUsuario);                
            }
        }
        
        return $response->withJson($aDados, 200);
    }
    
    private function updateDadosBanco($usucodigo, $ususenha){
        $ususenha = bcrypt($ususenha);
        
        list($oUsuario, $aDadosUsuario) = $this->getModelUsuario($usucodigo);
        
        // Atualiza o token do usuario        
        $token = encodeToken($oUsuario);
        
        if($this->getQuery()->executaQuery("update usuario set ususenha = '$ususenha', usutoken = '$token' 
                                             where usucodigo = $usucodigo")){
            return $aDadosUsuario;
        }
        
        return false;
    }
    
    private function getModelUsuario($usucodigo){
        $sql_usuario = "select * from usuario where usucodigo = $usucodigo";
    
        if($aDados = $this->getQuery()->selectAll($sql_usuario)){
            $aDadosUsuario = $aDados[0];
            $oUsuario = new Usuario($aDadosUsuario["usunome"],
                $aDadosUsuario["usuemail"],
                $aDadosUsuario["ususenha"],
                $aDadosUsuario["usutoken"],
                $aDadosUsuario["usuativo"]);
            
            return array($oUsuario, $aDadosUsuario);
        }
        
        return false;
    }
    
}