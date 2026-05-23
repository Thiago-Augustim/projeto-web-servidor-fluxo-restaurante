<?php

class ComandaModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConexao();
    }

    public function listar() {
        try {
            $sql = "SELECT * FROM comandas ORDER BY mesa ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarPorMesa($mesa) {
        try {
            $sql = "SELECT * FROM comandas WHERE mesa = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$mesa]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function buscarPorId($id) {
        try {
            $sql = "SELECT * FROM comandas WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function inserir($mesa) {
        try {
            $sql = "INSERT INTO comandas (mesa, itens, total) VALUES (?, '[]', 0)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$mesa]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar comanda: " . $e->getMessage());
        }
    }

    public function atualizar($id, $mesa, $itens, $total) {
        try {
            $sql = "UPDATE comandas SET mesa = ?, itens = ?, total = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$mesa, json_encode($itens), $total, $id]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar comanda: " . $e->getMessage());
        }
    }

    public function atualizarItens($mesa, $itens, $total) {
        try {
            $sql = "UPDATE comandas SET itens = ?, total = ? WHERE mesa = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([json_encode($itens), $total, $mesa]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar comanda: " . $e->getMessage());
        }
    }

    public function deletar($id) {
        try {
            $sql = "DELETE FROM comandas WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao deletar comanda: " . $e->getMessage());
        }
    }

    public function deletarPorMesa($mesa) {
        try {
            $sql = "DELETE FROM comandas WHERE mesa = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$mesa]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao deletar comanda: " . $e->getMessage());
        }
    }

    public function existeComandaAberta($mesa) {
        try {
            $sql = "SELECT COUNT(*) as count FROM comandas WHERE mesa = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$mesa]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function gerarComandaFechada($mesa) {
        try {
            $pedidos = Pedidos::buscarPorMesa($mesa);

            $comandaFechada = [
                'mesa' => $mesa,
                'itens' => [],
                'total' => 0
            ];

            foreach ($pedidos as $pedido) {
                // Ignora pedidos cancelados
                if ($pedido['status'] === 'cancelado') {
                    continue;
                }

                foreach ($pedido['itens'] as $item) {
                    $nome = $item['nome'];

                    if (!isset($comandaFechada['itens'][$nome])) {
                        $comandaFechada['itens'][$nome] = [
                            'nome' => $nome,
                            'quantidade' => 0,
                            'subtotal' => 0
                        ];
                    }

                    $comandaFechada['itens'][$nome]['quantidade'] += $item['quantidade'];
                    if (isset($item['preco'])) {
                        $subtotal = $item['quantidade'] * $item['preco'];
                        $comandaFechada['itens'][$nome]['subtotal'] += $subtotal;
                        $comandaFechada['total'] += $subtotal;
                    }
                }
            }

            return $comandaFechada;
        } catch (Exception $e) {
            throw new Exception("Erro ao gerar comanda fechada: " . $e->getMessage());
        }
    }

    public function salvarFechada($mesa, $itens, $total) {
        try {
            $sql = "INSERT INTO comandas_fechadas (mesa, itens, total) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$mesa, json_encode($itens), $total]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao salvar comanda fechada: " . $e->getMessage());
        }
    }

    public function listarFechadas() {
        try {
            $sql = "SELECT * FROM comandas_fechadas ORDER BY created_at DESC LIMIT 50";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $comandas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($comandas as &$comanda) {
                $comanda['itens'] = json_decode($comanda['itens'], true);
            }

            return $comandas;
        } catch (PDOException $e) {
            return [];
        }
    }
}
