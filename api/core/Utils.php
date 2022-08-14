<?php

/**
 * Arquivo com funções uteis
 * User: Gelvazio Camargo
 * Date: 10/12/2020
 * Time: 19:00
 */

//require_once 'lib/phpfastcache/phpfastcache.php';

class Utils {

    public static function isServidorProducao() {
        if(isset($_SERVER["APP_SERVIDOR_PRODUCAO"])){            
            return $_SERVER["APP_SERVIDOR_PRODUCAO"] === true;            
        }
        
        return true;
    }

    public static function getCacheServer()
    {
        // Ip da maquina local quando não estiver em nuvem
        $host = '192.168.1.2';
        $cache = phpFastCache("predis", array(
            "redis" => array(
                "host" => $host,
                "port" => 6379
            )
        ));

        return $cache;
    }

    public static function getRemoteIP()
    {
        $remoteIP = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $remoteIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            $remoteIP = $_SERVER["REMOTE_ADDR"];
        } else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
            $remoteIP = $_SERVER["HTTP_CLIENT_IP"];
        }

        if (stristr($remoteIP, ",")) {
            $listaIps = explode(",", $remoteIP);

            $remoteIP = $listaIps[0];
        }

        return $remoteIP;
    }

    public static function enviaMensagemSlack($assunto, $message, $room = "geral")
    {
        try {
            $assunto = str_ireplace("<br>", "\n", $assunto);
            $assunto = str_ireplace("<br/>", "\n", $assunto);

            $message = str_ireplace("<br>", "\n", $message);
            $message = str_ireplace("<br/>", "\n", $message);

            $data = "payload=" . json_encode(array(
                "channel" => "#{$room}",
                "text" => "[$assunto] \n$message"
            ));

            // You can get your webhook endpoint from your Slack settings
            $url_app_gelvazio = "https://hooks.slack.com/services/";
            if ($room == 'geral') {
                $url_app_gelvazio = "https://hooks.slack.com/services/";
            }

            $ch = curl_init($url_app_gelvazio);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);

            curl_close($ch);

            return $result;
        } catch (Exception $ex) {
        }
    }

    public static function sendSentry()
    {
        // Implementar envio de bugs  ao Sentry
    }

    public static function checkRateLimit($app, $tag)
    {
        // Implementar rate limits
        return true;

        // 50 Requisições por minuto
        if (!self::checkRateLimitRedis($app, $tag, 50, 60)) {
            return false;
        }

        // 500 Requisições por 10 minutos
        if (!self::checkRateLimitRedis($app, $tag, 500, 60 * 10)) {
            return false;
        }

        // 3000 Requisições por hora
        if (!self::checkRateLimitRedis($app, $tag, 3000, 60 * 60)) {
            return false;
        }

        // 30000 Requisições por 10 horas
        if (self::checkRateLimitRedis($app, $tag, 30000, 60 * 60 * 10)) {
            return false;
        }

        return true;
    }

    private static function checkRateLimitRedis($app, $key, $max, $time = 1)
    {
        if (trim($key) != "" && strlen(trim($key)) > 4) {
            $keyCache = "RATE_LIMIT_" . $app . "_" . $key . "_" . $max;

            $cache = Utils::getCacheServer();
            $object = $cache->get($keyCache, array('all_keys' => true));
            if ($object == null) {
                // quando nao existe, cria com o tempo certo
                $cache->set($keyCache, 0, $time);
            }

            // Feita implementacao aqui, pois estava acrescentando 5 anos, cada vez que expirava a primeira vez para cada chave
            $time_expired = $object['expired_time'] - @date("U");
            $count = intval($cache->get($keyCache));

            if ((int)$time_expired <= 0) {
                $cache->set($keyCache, 0, $time);
            } else {
                $count = $count + 1;
                $cache->set($keyCache, $count, $time_expired);
            }

            if ($count > $max) {
                $assunto = "Rate limit [$app]";
                $texto = "Key: $key<br>Count: $count <br>Max: $max<br>Time: $time";

                //Utils::slack($assunto, $texto, "geral");

                return false;
            }
        }
        return true;
    }

    public static function getConexao()
    {
        $IP = "";
        $DATABASE_NAME = "DATABASE_NAME";

        // Conecta no banco de dados
        $user = "USER";
        $password = "123456";

        // Conecta no banco de dados
        $conexaoBancoDados = pg_connect("host=$IP port=5432 dbname=$DATABASE_NAME user=$user password=$password");

        // Coloca o cliente enconding
        pg_set_client_encoding($conexaoBancoDados, "UTF-8");

        // Define o nome da aplicação
        $appName = "factor-erp";

        pg_query("SET application_name = '$appName';");

        // Retorna a conexao
        return $conexaoBancoDados;
    }
    
    public static function getDirTempFile() {
        return "/var/www/html/temp";        
    }
}
