<?php

class Redirecionador {

    static $oParametros = Array();

    public function __construct() {
        $this->getAllParametros();
        $this->verificaDestino();
    }

    private function verificaDestino() {
        if (self::getParametro('pagina')) {
            $sController = 'Controller' . $_GET['pagina'];
            if (file_exists('./controller/' . $sController . '.php')) {
                $oController = new $sController();
                $oController->processa();
            } else {
                throw new Exception('Página solicitada não encontrada! ' . $sController);
            }
        } else if (file_exists('./controller/ControllerHome.php')) {
            $oControllerHome = new ControllerHome();
            $oControllerHome->processa();
        } else {
            throw new Exception('Página home não encontrada! ' . $oControllerHome);
        }
    }

    private function getAllParametros() {
        foreach ($_GET as $chave => $valor) {
            self::$oParametros[$chave] = $valor;
        }
        foreach ($_POST as $chave => $valor) {
            self::$oParametros[$chave] = $valor;
        }
    }

    public static function getParametro($name) {
        if (isset(self::$oParametros[$name])) {
            return self::$oParametros[$name];
        }
        return false;
    }

}