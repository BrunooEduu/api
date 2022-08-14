<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class ControllerApiUpdateDatabase {
    
    public function updateDatabase(Request $request, Response $response, array $args) {
        
        $users      = $this->updateUsers();
        $atividades = $this->updateAtividades();
        $feedbacks  = $this->updateFeedbacks();
        $auxilios   = $this->updateAuxilios();
        
        return $response->withJson(array(
            "users"      => array("statusOk"   => $users),
            "atividades" => array("atividades" => $atividades),
            "feedbacks"  => array("feedbacks"  => $feedbacks),
            "auxilios"   => array("auxilios"   => $auxilios)
        ),200);
    }
    
    private function updateAtividades(){
        return true;
    }
    
    private function updateFeedbacks(){
        return true;
    }
    
    private function updateAuxilios(){ 
        return true; 
    }
    
    private function updateUsers(){
        // carrega os dados do heroku
        $_SERVER["APP_SERVIDOR_PRODUCAO"] = true;
        
        $sql = "select * from usuario";
        $aDadosHeroku = $this->getQuery()->selectAll($sql);
        
        // carrega os dados da Supabase
        $_SERVER["APP_SERVIDOR_PRODUCAO"] = false;
        $aDadosSupabase = $this->getQuery()->selectAll($sql);
        
        $aDadosAtualizarSupabase = array();
        foreach ($aDadosHeroku as $oDados){
            // verifica se tem dados do heroku e nao tem na Supabase
            $existeSupabase = false;
            foreach ($aDadosSupabase as $oDadosSupabase){
                if($oDadosSupabase["usuemail"] == $oDados["usuemail"]){
                    $existeSupabase = true;
                    break;
                }
            }            
            
            if(!$existeSupabase){
                array_push($aDadosAtualizarSupabase, $oDados);
            }
        }
        
        // Atualiza a Supabase
        
        return true;
    }
    
 
}
