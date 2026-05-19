<?php

use Carbon\Carbon;

class Pedidos {

    public static function todos() {
        $db = Database::getConexao();
        $stmt = $db->query('SELECT * FROM pedidos');
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($pedidos as &$pedido) {
            $pedido['itens'] = json_decode($pedido['itens'], true);
            $pedido['tempo'] = Carbon::parse($pedido['created_at'], 'America/Sao_Paulo')->diffForHumans();
        }
        
        return $pedidos;
    }

    public static function cadastrar($numeroMesa, $itens) {
        $db = Database::getConexao();
        $stmt = $db->prepare('INSERT INTO pedidos (numeroMesa, status, itens) VALUES (:numeroMesa, :status, :itens)');
        $stmt->execute([
            ':numeroMesa' => $numeroMesa,
            ':status'     => 'aguardando',
            ':itens'      => json_encode($itens)
        ]);
    }

    public static function alterarStatus($id, $status) {
        $db = Database::getConexao();
        $stmt = $db->prepare('UPDATE pedidos SET status = :status WHERE id = :id');
        $stmt->execute([
            ':status' => $status,
            ':id'     => $id
        ]);
    }
}