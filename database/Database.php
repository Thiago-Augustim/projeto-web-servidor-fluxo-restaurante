<?php

class Database {
    private static $conexao = null;

    public static function getConexao() {
        if (self::$conexao === null) {
            try {
                self::$conexao = new PDO(
                    'mysql:host=localhost;dbname=fluxo_restaurante;charset=utf8',
                    'root',
                    ''
                );
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erro ao conectar com o banco: ' . $e->getMessage());
            }
        }
        return self::$conexao;
    }
}