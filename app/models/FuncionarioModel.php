<?php

class FuncionarioModel {
    use ConexaoBD;

    public function listar() {
        try {
            $sql = "SELECT id, nome, usuario, especialidade FROM funcionarios ORDER BY nome ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarPorId($id) {
        try {
            $sql = "SELECT id, nome, usuario, especialidade FROM funcionarios WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function buscarPorUsuario($usuario) {
        try {
            $sql = "SELECT * FROM funcionarios WHERE usuario = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function inserir($nome, $usuario, $especialidade, $senha) {
        try {
            $sql = "INSERT INTO funcionarios (nome, usuario, especialidade, senha) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$nome, $usuario, $especialidade, password_hash($senha, PASSWORD_DEFAULT)]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao inserir funcionário: " . $e->getMessage());
        }
    }

    public function deletar($id) {
        try {
            $sql = "DELETE FROM funcionarios WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao deletar funcionário: " . $e->getMessage());
        }
    }

    public function verificarUsuarioExistente($usuario, $id = null) {
        try {
            if ($id) {
                $sql = "SELECT COUNT(*) as count FROM funcionarios WHERE usuario = ? AND id != ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$usuario, $id]);
            } else {
                $sql = "SELECT COUNT(*) as count FROM funcionarios WHERE usuario = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$usuario]);
            }
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
