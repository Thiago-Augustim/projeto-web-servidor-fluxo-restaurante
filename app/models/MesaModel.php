<?php

class MesaModel {
    use ConexaoBD;

    public function listar() {
        try {
            $sql = "SELECT * FROM mesas ORDER BY numero ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarPorNumero($numero) {
        try {
            $sql = "SELECT * FROM mesas WHERE numero = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$numero]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function buscarPorId($id) {
        try {
            $sql = "SELECT * FROM mesas WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function inserir($numero, $cadeiras, $status) {
        try {
            $sql = "INSERT INTO mesas (numero, cadeiras, status) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$numero, $cadeiras, $status]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao inserir mesa: " . $e->getMessage());
        }
    }

    public function atualizar($id, $numero, $cadeiras, $status) {
        try {
            $sql = "UPDATE mesas SET numero = ?, cadeiras = ?, status = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$numero, $cadeiras, $status, $id]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar mesa: " . $e->getMessage());
        }
    }

    public function atualizarStatus($numero, $status) {
        try {
            $sql = "UPDATE mesas SET status = ? WHERE numero = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $numero]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar status: " . $e->getMessage());
        }
    }

    public function deletar($id) {
        try {
            $sql = "DELETE FROM mesas WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao deletar mesa: " . $e->getMessage());
        }
    }

    public function verificarNumeroExistente($numero, $id = null) {
        try {
            if ($id) {
                $sql = "SELECT COUNT(*) as count FROM mesas WHERE numero = ? AND id != ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$numero, $id]);
            } else {
                $sql = "SELECT COUNT(*) as count FROM mesas WHERE numero = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$numero]);
            }
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
