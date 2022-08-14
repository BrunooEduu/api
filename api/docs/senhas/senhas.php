<?php

$senha = '123456';

$senha_com_md5 = md5($senha);

echo 'Senha sem MD5:<br>' . $senha;
echo '<br> Senha com MD5:<br>' . $senha_com_md5;

echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';

require_once ("token.php");

$api_key = "769E46AAD7AD1833E3174B6E88CCC-F373C6DC6367A967B242CA4CCDDA2";

$token = encodeToken($senha, $api_key);

echo '<br>Token JWT gerado:<br>' . $token;

$token_decode = decodeToken($token, $api_key);

echo '<br>Token JWT decodificado:<br>' . json_encode($token_decode);

echo '<br>';
echo '<br>';
echo '<br>';
echo 'Senha informada pelo usuario:' . $senha;

echo '<br>';
echo '<br>';
$senha_banco_dados = $token_decode->senha;
echo 'Senha do banco de dados encriptada:' . $token_decode->senha;

echo '<br>';
echo '<br>';
$senha_usuario_encriptada = bcrypt($senha);
echo 'Senha informada pelo usuario encriptada:' . $senha_usuario_encriptada;

if (password_verify($senha, $senha_banco_dados)) {
    echo '<br>';
    echo '<br>';
    echo '<br>';
    // Valida o acesso
    echo 'Bem vindo usuario:' . $token_decode->usunome;
    echo '<br>Acesso valido!<br>';
} else {
    echo '<br>Acesso inválido!<br>';
}
