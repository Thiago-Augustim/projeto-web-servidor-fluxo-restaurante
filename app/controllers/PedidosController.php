<?php

require_once MIDDLEWARES . 'Auth.php';
require_once MODELS . 'ComandaModel.php';
require_once MODELS . 'MesaModel.php';

function pedidosIndex(): void
{
    global $permissoes;
    validarAcesso($permissoes);

    $pedidos = Pedidos::todos();

    require VIEWS . 'PedidosView.php';
}

function cadastrarPedido(): void
{
    $numeroMesa = $_POST['numeroMesa'] ?? null;
    $itens = $_POST['itens'] ?? null;

    if (!$numeroMesa || !$itens) {
        $_SESSION['erros'] = ['O pedido não pode ser vazio'];
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }

    try {
        $comandaModel = new ComandaModel();

        // Cria comanda automaticamente se não existir
        if (!$comandaModel->existeComandaAberta($numeroMesa)) {
            $comandaModel->inserir($numeroMesa);
        }

        // Cadastra pedido
        Pedidos::cadastrar($numeroMesa, $itens);

        $_SESSION['sucesso'] = "Pedido cadastrado com sucesso!";
    } catch (Exception $e) {
        $_SESSION['erros'] = [$e->getMessage()];
    }

    header('Location: ' . BASE_URL . '?rota=mesas');
    exit();
}

function alterarStatusPedido(): void
{
    $id     = $_POST['id']     ?? null;
    $status = $_POST['status'] ?? null;

    $statusValidos = ['aguardando', 'em_preparo', 'concluido', 'cancelado'];

    if (!$id || !in_array($status, $statusValidos)) {
        $_SESSION['erros'] = ['Selecione um pedido para alterar o status'];
        header('Location: ' . BASE_URL . '?rota=pedidos');
        exit();
    }

    try {
        // Busca pedido para validar
        $pedidos = Pedidos::todos();
        $pedidoAtual = null;

        foreach ($pedidos as $pedido) {
            if ($pedido['id'] == $id) {
                $pedidoAtual = $pedido;
                break;
            }
        }

        if (!$pedidoAtual) {
            $_SESSION['erros'] = ['Pedido não encontrado'];
            header('Location: ' . BASE_URL . '?rota=pedidos');
            exit();
        }

        // Valida se pedido está em estado final
        if ($pedidoAtual['status'] === 'cancelado' || $pedidoAtual['status'] === 'concluido') {
            $_SESSION['erros'] = ['Este pedido já está ' . ucfirst($pedidoAtual['status']) . ' e não pode ser alterado'];
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
