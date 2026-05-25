<?php

class PedidosController {
    use RespostaController;

    public static function index(): void
    {
        if (!isset($_SESSION['logado'])) {
            self::redirecionar('login');
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
            self::redirecionar('mesas', null, ['O pedido não pode ser vazio.']);
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

        self::redirecionar('mesas');
    }

    public static function alterarStatus(): void
    {
        $id     = $_POST['id']     ?? null;
        $status = $_POST['status'] ?? null;
        $statusValidos = ['aguardando', 'em_preparo', 'concluido', 'cancelado'];

        if (!$id || !in_array($status, $statusValidos)) {
            self::redirecionar('pedidos', null, ['Selecione um pedido para alterar o status.']);
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
                self::redirecionar('pedidos', null, ['Pedido não encontrado.']);
            }

            if (in_array($pedidoAtual['status'], ['cancelado', 'concluido'])) {
                self::redirecionar('pedidos', null, ['Este pedido já está ' . ucfirst($pedidoAtual['status']) . ' e não pode ser alterado.']);
            }

            Pedidos::alterarStatus($id, $status);
            $_SESSION['sucesso'] = "Status do pedido alterado com sucesso!";
        } catch (Exception $e) {
            $_SESSION['erros'] = [$e->getMessage()];
        }

        self::redirecionar('pedidos');
    }
}
