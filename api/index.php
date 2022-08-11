<?php

header("Access-Control-Allow-Origin: true");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');
date_default_timezone_set('America/Maceio');

use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once "lib/slim/autoload.php";
require_once("./core/Utils.php");

require_once("./controllers/ControllerApiBase.php");
require_once("./controllers/ControllerApiUsuario.php");

class Routes
{

    public function __construct()
    {
        $this->runApp();
    }

    /**
     * Executa o app para realizar a chamada de rotas
     *
     * @throws Throwable
     */
    protected function runApp()
    {
        $app = new \Slim\App($this->getConfigurationContainer());

        // Agrupando rotas para adicionar o middleware em todas as rotas de uma só vez
        $app->group('', function () use ($app) {

            // Pagina inicial da api
            $app->get('/', ControllerApiBase::class . ':callPing');

            $app->get('/ping', ControllerApiBase::class . ':callPing');

            // Cadastros
            $app->get('/users', ControllerApiUsuario::class . ':getUsuario');
        })->add($this->getMiddlewares());

        $app->run();
    }

    /**
     * Retorna a configuração das rotas
     *
     * @return \Slim\Container
     */
    private function getConfigurationContainer()
    {
        // Configuração de erros
        $configuration = [
            'settings' => [
                'displayErrorDetails' => true,
            ],
        ];
        $configurationContainer = new \Slim\Container($configuration);

        return $configurationContainer;
    }

    /**
     * Valida se o token é valido
     *
     * @param $token
     * @return bool
     */
    public static function isValidToken($token)
    {
        require_once("core/Query.php");
        $oQuery = new Query();

        $aDados = $oQuery->select("select usutoken as token
                                    from usuario
                                   where usuario.usutoken = '$token'
                                     and coalesce(usuario.usuativo, 0) = 1");

        if (!$aDados) {
            return false;
        }

        $token_api = Routes::getTokenApi();
        $token_usuario = $aDados["token"];
        if ($token_api === $token_usuario) {
            return true;
        }

        return false;
    }

    /**
     * Retorna os midlewares de validação de rotas
     *
     * @return Closure
     */
    private function getMiddlewares()
    {
        // Middlewares
        $Middlware = function (Request $request, Response $response, $next) {
            //
            // // Valida as requisições
            // if (!Utils::checkRateLimit("API", Utils::getRemoteIP())) {
            //     $data = array("message" => "Excesso de chamadas");
            //     return $response->withJson($data, 429);
            // }
            //
            // $headers = $request->getHeaders();
            //
            // $data = array("headers" => json_encode($headers));
            //
            // $token = "TOKEN_VAZIO";
            // if(isset($headers["HTTP_X_API_KEY"]) && is_array($headers["HTTP_X_API_KEY"])){
            //     $token = $headers["HTTP_X_API_KEY"][0];
            //     if (trim($token) == "") {
            //         $data = array("message" => "Acesso inválido - TOKEN - Envio:" . $token);
            //         return $response->withJson($data, 401);
            //     }
            //
            //     // Verifica se esse token é valido
            //     if (!Routes::isValidToken($token)) {
            //         $data = array("message" => "Token inválido");
            //         return $response->withJson($data, 401);
            //     }
            // } else {
            //     $data = array("message" => "Token inválido!");
            //     return $response->withJson($data, 401);
            // }

            $response = $next($request, $response);

            return $response;
        };

        return $Middlware;
    }

    private static function getTokenApi()
    {
        return 'BE406D16ABFB8AB03A6AC07C25EBFA9E0D05DB778E0E679F214A13180530D46E1E62D206D4DF7FF8397B18DEFBE3847334809E314AAD2607E15DE7F9597CC990';
    }
}

$routes = new Routes();
