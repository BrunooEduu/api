<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class ControllerApiUpdateDatabase {
    
    public function updateDatabase(Request $request, Response $response, array $args) {
        
        
        $file_csv_1 = file_get_contents('docs/auxilioemergencial_rows_1.csv');
        
        $aDados = explode(";", $file_csv_1);
    
        $dados_01 = "NADA";
        
        $xDados = "false";
        $id = 0;
        $id2 = 0;
        $id3 = 0;
        $id4 = 0;
        foreach ($aDados as $oDados){
            $xDados = $oDados;
            
            
            
            $oDados = explode(",", $oDados);
            $id  = $oDados[0];
            $id2 = $oDados[1];
            $id3 = $oDados[2];
            $id4 = $oDados[3];
            
            $string_dados = $id . ',' . $id2 . ',' .  $id3 . ',';
            
            //$length = strlen($id . ',' . $id2 . ',' .  $id3 . ',' . $id4);
            
            $nova_string = str_replace($string_dados, '', $xDados);
            
            $oDadosObject = json_decode($nova_string);
            
            $dados_01 .= $oDados[0];
            $dados_01 .= $oDados[1];
            $dados_01 .= $oDados[2];
            $dados_01 .= $oDados[3];
            
            
            break;
        }
        
        // buscando dados da api
        
        return $response->withJson(
            array("id" => $id,
                "id2" => $id2,
                "id3" => $id3,
                "id4" => $id4,
                "statusOk" => $xDados), 200);

        
        
        //return $response->withJson(array("statusOk" => true), 200);
    }
    
    private function loadDataAuxilioEmergencial(){
        var url = "https://api.portaldatransparencia.gov.br/api-de-dados/auxilio-emergencial-beneficiario-por-municipio";
    
        if (mes == undefined) {
            mes = 202101;
        }
    
        var params = "?codigoIbge=4214805&mesAno=" + mes + "&pagina=1";
    
    
        url = url + params;
    
    }
}
