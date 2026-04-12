<?php

function pedidosIndex(): void
{
   
    if (!isset($_SESSION['pedidos'])) {
        $_SESSION['pedidos'] = require MODELS . 'Pedidos.php';
    }

    $pedidos = $_SESSION['pedidos'];

    require VIEWS . 'PedidosView.php';
}

function cadastrarPedido(): void
{
    $numeroMesa = $_POST['numeroMesa'] ?? null;
    $itens = $_POST['itens']    ?? null;


    if (!$numeroMesa || !$itens) {
        $_SESSION['erros'] = ['O pedido Não pode ser Vazio'];
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }

    if (!isset($_SESSION['pedidos'])) {
        $_SESSION['pedidos'] = [];
    }

    $_SESSION['pedidos'] [] = [
        'id' => count($_SESSION['pedidos']) + 1,
        'numeroMesa' => $numeroMesa,
        'status' => "aguardando",
        'itens'=> $itens
    ];


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

    foreach ($_SESSION['pedidos'] as &$pedido) {
        if ($pedido['id'] == $id) {
            $pedido['status'] = $status;
            break;
        }
    }

    header('Location: ' . BASE_URL . '?rota=pedidos');
    exit();
}
