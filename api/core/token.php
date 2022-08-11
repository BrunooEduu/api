<?php

/*
 Tabela de usuario
create table usuario (
    usucodigo int not null,
    usunome varchar(200) not null,
    usugrupo int not null,
    usuemail varchar(50) not null, -- so pode ter um email por usuario
    ususenha varchar(50) not null,
    usuativo int not null,
    pk - usucodigo
);

Tabela de grupo
create table grupo (
    grucodigo int not null,
    grudescricao(200) not null,
    pk - grucodigo
);

// Tabela de grupo e usuario

// Vai listar qual tela cada usuario pode acessar
// Criar tabela de tela x grupo
// Cada grupo tem uma lista de telas

// criar tabela de nome telas
    codigo - codigo da tela
    descricao - nome da tela
    observacao - para qeu e usada a tela


 *
 * */
function encodeToken($ususenha){
    // gerado token do site:https://randomkeygen.com/
    // E passado por usuario
    $tokenApi = "fKhVFZyB7m-n92D322ghM-H9J09YnTbM-33XecKDgIH-dsX5vAxgrV-YwPCnGxPVz";

    // Serve para todo o sistema
    $api_key = "769E46AAD7AD1833E3174B6E88CCC-F373C6DC6367A967B242CA4CCDDA2";

    $ususenha = "123456";
    $ususenha = bcrypt($ususenha);

    $jwtKey = "sistema-" . date("Y-m-d") . "-key-jwt-" . $api_key;

    $usucodigo = intval($usucodigo);
    $codigo_grupo = "select usugrupo from usuario where usucodigo = $usucodigo";
    $dados = array(
        "usucodigo" => $usucodigo,
        "grupo"     => $codigo_grupo,
        "data"      => date("Y-m-d"),
        "x-api-key" => $tokenApi,
        "senha"     => $ususenha
    );

    require_once 'lib/jwt/jwt_helper.php';

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
function decodeToken($token, $api_key) {
    $jwtKey = "sistema-" . date("Y-m-d") . "-key-jwt-" . $api_key;

    require_once 'lib/jwt/jwt_helper.php';

    return JWT::decode($token, $jwtKey);
}
