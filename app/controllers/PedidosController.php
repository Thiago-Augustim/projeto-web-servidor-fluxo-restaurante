<?php

require_once MIDDLEWARES . 'Auth.php';

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
        $_SESSION['erros'] = ['O pedido Não pode ser Vazio'];
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }

    Pedidos::cadastrar($numeroMesa, $itens);

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

    Pedidos::alterarStatus($id, $status);

    header('Location: ' . BASE_URL . '?rota=pedidos');
    exit();
}