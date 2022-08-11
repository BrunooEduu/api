<?php
//Â Desativa toda exibiÃ§Ã£o de erros
//error_reporting(0);

// Exibe erros simples
//error_reporting(E_ERRORÂ |Â E_WARNINGÂ |Â E_PARSE);
//
//// Exibir E_NOTICE tambem pode ser bom para mostrar variaveis nao iniciadas...
//// ou com erros de digitacao.
//error_reporting(E_ERRORÂ |Â E_WARNINGÂ |Â E_PARSEÂ |Â E_NOTICE);
//
// Exibe todos os erros, exceto E_NOTICE
// error_reporting(E_ALL & E_NOTICE);
//
// Exibe todos os erros PHP (seeÂ changelog)
// error_reporting(E_ALL);

//Â Exibe todos os erros PHP
error_reporting(-1);

// Mesmo que 
error_reporting(E_ALL);
//ini_set('error_reporting',Â E_ALL);

function __autoload($className) {
    if (strpos($className, 'Controller') !== false) {
        require_once('controller/' . $className . '.php');
    } else if (strpos($className, 'View') !== false) {
        require_once('view/' . $className . '.php');
    } else if (strpos($className, 'Persistencia') !== false) {
        require_once('persistencia/' . $className . '.php');
    } else if (strpos($className, 'Model') !== false) {
        require_once('model/' . $className . '.php');
    } else {
        require_once('core/' . $className . '.php');
    }
}