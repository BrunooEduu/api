<?php

class ConexaoDB
{

    // Conexao Local
    // const HOST   = '127.0.0.1';
    // const PORT   = '5432';
    // const DBNAME = 'postgres';
    // const USER   = 'postgres';
    // const PASS   = 'postgres';

    const HOST   = 'db.vdcszqvvrwdqcnjvcoxt.supabase.co';
    const DBNAME = 'postgres';
    const PORT   = '5432';
    const USER   = 'postgres';
    const PASS   = 'mB9C@SywfzkJzmS';

    private static $conexao = null;

    public static function getInstance() {
        if (is_null(self::$conexao)) {
            self::conecta();
        }
        return self::$conexao;
    }

    public static function conecta()
    {
        if (is_null(self::$conexao)) {
    
            $HOST   = $_SERVER["APP_DATABASE_HOST"];
            $DBNAME = $_SERVER["APP_DATABASE_DBNAME"];
            $PORT   = $_SERVER["APP_DATABASE_PORT"];
            $USER   = $_SERVER["APP_DATABASE_USER"];
            $PASS   = $_SERVER["APP_DATABASE_PASS"];
            
            //
            // throw new Exception('Erro ao comunicar com banco de dados!
            //     <br>host:' . $HOST . ' 
            //     <br>dbname : '. $DBNAME .'
            //     <br>port : '. $PORT .'
            //     <br>user : '. $USER .'
            //     <br>pass : '. $PASS
            // );
            //
            
            if(Utils::isServidorProducao()){
                $HOST   = 'db.vdcszqvvrwdqcnjvcoxt.supabase.co';
                $DBNAME = 'postgres';
                $PORT   = '5432';
                $USER   = 'postgres';
                $PASS   = 'mB9C@SywfzkJzmS';                
            }
            
            self::$conexao = pg_connect('host=' . $HOST . ' port=' . $PORT . ' dbname=' . $DBNAME . ' user=' . $USER . ' password=' . $PASS);
            if (self::$conexao === false) {
                throw new Exception('Erro ao comunicar com banco de dados!');
            }
        }
        return self::$conexao;
    }

    public static function desconecta()
    {
        $bFechou = true;
        if (!is_null(self::$conexao)) {
            $bFechou = pg_close(self::$conexao);
            self::$conexao = null;
        }
        return $bFechou;
    }

    public function __destruct()
    {
        self::desconecta();
    }
}
