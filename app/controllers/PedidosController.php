<?php

class PedidosController {
    public static function index(): void
    {
        if (!isset($_SESSION['logado'])) {
            header("Location: " . BASE_URL . "?rota=login");
            exit();
        }

        Auth::validarAcesso();

        $pedidos = Pedidos::todos();

        require VIEWS . 'PedidosView.php';
    }

    public static function cadastrar(): void
    {
        $numeroMesa = $_POST['numeroMesa'] ?? null;
        $itens      = $_POST['itens']      ?? null;

        if (!$numeroMesa || !$itens) {
            $_SESSION['erros'] = ['O pedido não pode ser vazio.'];
            header('Location: ' . BASE_URL . '?rota=mesas');
            exit();
        }

        try {
            $comandaModel = new ComandaModel();

            if (!$comandaModel->existeComandaAberta($numeroMesa)) {
                $comandaModel->inserir($numeroMesa);
            }

            Pedidos::cadastrar($numeroMesa, $itens);
            $_SESSION['sucesso'] = "Pedido cadastrado com sucesso!";
        } catch (Exception $e) {
            $_SESSION['erros'] = [$e->getMessage()];
        }

        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }

    public static function alterarStatus(): void
    {
        $id     = $_POST['id']     ?? null;
        $status = $_POST['status'] ?? null;
        $statusValidos = ['aguardando', 'em_preparo', 'concluido', 'cancelado'];

        if (!$id || !in_array($status, $statusValidos)) {
            $_SESSION['erros'] = ['Selecione um pedido para alterar o status.'];
            header('Location: ' . BASE_URL . '?rota=pedidos');
            exit();
        }

        try {
            $pedidoAtual = null;
            foreach (Pedidos::todos() as $pedido) {
                if ($pedido['id'] == $id) {
                    $pedidoAtual = $pedido;
                    break;
                }
            }

            if (!$pedidoAtual) {
                $_SESSION['erros'] = ['Pedido não encontrado.'];
                header('Location: ' . BASE_URL . '?rota=pedidos');
                exit();
            }

            if (in_array($pedidoAtual['status'], ['cancelado', 'concluido'])) {
                $_SESSION['erros'] = ['Este pedido já está ' . ucfirst($pedidoAtual['status']) . ' e não pode ser alterado.'];
                header('Location: ' . BASE_URL . '?rota=pedidos');
                exit();
            }

            Pedidos::alterarStatus($id, $status);
            $_SESSION['sucesso'] = "Status do pedido alterado com sucesso!";
        } catch (Exception $e) {
            $_SESSION['erros'] = [$e->getMessage()];
        }

        header('Location: ' . BASE_URL . '?rota=pedidos');
        exit();
    }
}
