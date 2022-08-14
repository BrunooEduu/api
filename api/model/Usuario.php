<?php

class Usuario {
    
    private $usucodigo;
    private $usunome;
    private $usuemail;
    private $ususenha;
    private $usutoken;
    private $usuativo;
    
    /**
     * Usuario constructor.
     * @param $usunome
     * @param $usuemail
     * @param $ususenha
     * @param $usutoken
     * @param $usuativo
     */
    public function __construct($usunome, $usuemail, $ususenha, $usutoken, $usuativo) {
        $this->usunome = $usunome;
        $this->usuemail = $usuemail;
        $this->ususenha = $ususenha;
        $this->usutoken = $usutoken;
        $this->usuativo = $usuativo;
    }    
    
    /**
     * @return mixed
     */
    public function getUsucodigo() {
        return $this->usucodigo;
    }
    
    /**
     * @param mixed $usucodigo
     * @return Usuario
     */
    public function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getUsunome() {
        return $this->usunome;
    }
    
    /**
     * @param mixed $usunome
     * @return Usuario
     */
    public function setUsunome($usunome) {
        $this->usunome = $usunome;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getUsuemail() {
        return $this->usuemail;
    }
    
    /**
     * @param mixed $usuemail
     * @return Usuario
     */
    public function setUsuemail($usuemail) {
        $this->usuemail = $usuemail;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getUsusenha() {
        return $this->ususenha;
    }
    
    /**
     * @param mixed $ususenha
     * @return Usuario
     */
    public function setUsusenha($ususenha) {
        $this->ususenha = $ususenha;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getUsutoken() {
        return $this->usutoken;
    }
    
    /**
     * @param mixed $usutoken
     * @return Usuario
     */
    public function setUsutoken($usutoken) {
        $this->usutoken = $usutoken;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getUsuativo() {
        return $this->usuativo;
    }
    
    /**
     * @param mixed $usuativo
     * @return Usuario
     */
    public function setUsuativo($usuativo) {
        $this->usuativo = $usuativo;
        return $this;
    }
}