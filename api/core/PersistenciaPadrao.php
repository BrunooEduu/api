<?php

/* Responsável por realizar obter os modelos e realizar as operações no banco de dados */
require_once ("Query.php");
abstract class PersistenciaPadrao {

    /**
     *
     * @var ModelPadrao
     */
    protected $Model;

    /**
     *
     * @var Query
     */
    private $Query;

    /* Responsável por Inserir os dados no banco de dados através do modelo de dados */

    abstract function insere();

    /* Responsável por Alterar os dados no banco de dados através do modelo de dados */

    abstract function altera();

    /* Responsável por Excluir os dados no banco de dados através do modelo de dados */

    abstract function exclui();

    /* Responsável por Obter os dados no banco de dados através de um modelo de dados */

    abstract function get();

    /* Responsável por Obter todos os modelos no banco de dados através */

    abstract function getAll();

    /* Responsável por receber um array retornado do banco de dados e retornar um modelo de dados populado */

    abstract function getModelFromDb($aValor);

    function getQuery() {
        if (!isset($this->Query)) {
            $this->Query = new Query();
        }
        return $this->Query;
    }

    function setQuery(Query $Query) {
        $this->Query = $Query;
    }

    function getModel() {
        return $this->Model;
    }

    function setModel(ModelPadrao $Model) {
        $this->Model = $Model;
    }

}