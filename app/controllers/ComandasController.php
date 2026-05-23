<?php

class ComandasController {
    public static function index(): void
    {
        if (!isset($_SESSION['logado'])) {
            header("Location: " . BASE_URL . "?rota=login");
            exit();
        }

        Auth::validarAcesso();

        $comandaModel   = new ComandaModel();
        $pedidos        = Pedidos::todos();
        $comandas       = [];

        foreach ($pedidos as $pedido) {
            if ($pedido['status'] === 'cancelado') continue;

            $mesa = $pedido['numeroMesa'];

            if (!isset($comandas[$mesa])) {
                $comandas[$mesa] = ['mesa' => $mesa, 'itens' => [], 'total' => 0];
            }

            foreach ($pedido['itens'] as $item) {
                $nome = $item['nome'];

                if (!isset($comandas[$mesa]['itens'][$nome])) {
                    $comandas[$mesa]['itens'][$nome] = ['nome' => $nome, 'quantidade' => 0, 'subtotal' => 0];
                }

                $comandas[$mesa]['itens'][$nome]['quantidade'] += $item['quantidade'];

                if (isset($item['preco'])) {
                    $subtotal = $item['quantidade'] * $item['preco'];
                    $comandas[$mesa]['itens'][$nome]['subtotal'] += $subtotal;
                    $comandas[$mesa]['total'] += $subtotal;
                }
            }
        }

        ksort($comandas);

        $comandasFechadas = $comandaModel->listarFechadas();

        require VIEWS . 'ComandasView.php';
    }

    public static function fechar(): void
    {
        $mesa = $_POST['mesa'] ?? null;

        if (!$mesa) {
            $_SESSION['erros'] = ['Selecione uma comanda para finalizar.'];
            header("Location: " . BASE_URL . "?rota=comandas");
            exit();
        }

        try {
            $comandaModel = new ComandaModel();
            $pedidos      = Pedidos::buscarPorMesa($mesa);

            $temPendente = false;
            foreach ($pedidos as $pedido) {
                if (!in_array($pedido['status'], ['concluido', 'cancelado'])) {
                    $temPendente = true;
                    break;
                }
            }

            if ($temPendente) {
                $_SESSION['erros'] = ['Há pedidos que não foram concluídos. Todos devem estar concluídos para fechar a comanda!'];
                header("Location: " . BASE_URL . "?rota=comandas");
                exit();
            }

            $comandaFechada = $comandaModel->gerarComandaFechada($mesa);
            $comandaModel->salvarFechada($mesa, $comandaFechada['itens'], $comandaFechada['total']);
            $comandaModel->deletarPorMesa($mesa);

            foreach ($pedidos as $pedido) {
                Pedidos::deletar($pedido['id']);
            }

            (new MesaModel())->atualizarStatus($mesa, 'livre');
            $_SESSION['sucesso'] = "Comanda fechada com sucesso!";
        } catch (Exception $e) {
            $_SESSION['erros'] = [$e->getMessage()];
        }

        header("Location: " . BASE_URL . "?rota=comandas");
        exit();
    }
}
