<?php

function encodeToken(/**@var $oUsuario Usuario*/ $oUsuario, $api_key = "769E46AAD7AD1833E3174B6E88CCC-F373C6DC6367A967B242CA4CCDDA2"){
    // gerado token do site:https://randomkeygen.com/
    
    // cada usuario tem sua token api
    $tokenApi = "fKhVFZyB7m-n92D322ghM-H9J09YnTbM-33XecKDgIH-dsX5vAxgrV-YwPCnGxPVz";

    $jwtKey = "sistema-" . date("Y-m-d") . "-key-jwt-" . $api_key;

    $dados = array(
        "usuemail" => $oUsuario->getUsuemail(),
        "ususenha" => bcrypt($oUsuario->getUsusenha()),
        "data"     => date("Y-m-d"),
        "x-api-key"=> $tokenApi
    );

    require_once './lib/jwt/jwt_helper.php';
    
    return JWT::encode($dados, $jwtKey);
}

function bcrypt($ususenha){
    $options = [ 'cost' => 11 ];

    $passwd = password_hash($ususenha, PASSWORD_BCRYPT, $options);

    return $passwd;
}

/**
 * Decodifica o token
 * @param $token
 * @param $api_key
 * @return object
 */
function decodeToken($token, $api_key = '769E46AAD7AD1833E3174B6E88CCC-F373C6DC6367A967B242CA4CCDDA2') {
    $jwtKey = "sistema-" . date("Y-m-d") . "-key-jwt-" . $api_key;

    require_once './lib/jwt/jwt_helper.php';

    return JWT::decode($token, $jwtKey);
}
