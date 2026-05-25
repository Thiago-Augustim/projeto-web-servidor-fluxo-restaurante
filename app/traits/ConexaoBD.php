<?php

trait ConexaoBD {
    private $db;

    public function __construct() {
        $this->db = Database::getConexao();
    }
}
