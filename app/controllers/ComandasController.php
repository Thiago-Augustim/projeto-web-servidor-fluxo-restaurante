<?php
require_once MIDDLEWARES . 'Auth.php';

function comandasIndex(): void
{
    if (!isset($_SESSION['logado'])) {
        header("Location: " . BASE_URL . "?rota=login");
        exit();
    }

    global $permissoes;
    validarAcesso($permissoes);

    // Se não existir pedidos na sessão, inicializa vazio
    if (!isset($_SESSION['pedidos'])) {
        $_SESSION['pedidos'] = [];
    }

    $pedidos = $_SESSION['pedidos'];

    $comandas = [];

    foreach ($pedidos as $pedido) {

        $mesa = $pedido['numeroMesa'];

        //ignora pedidos cancelados (opcional)
        if ($pedido['status'] === 'cancelado') {
            continue;
        }

        // cria a comanda da mesa se não existir
        if (!isset($comandas[$mesa])) {
            $comandas[$mesa] = [
                'mesa' => $mesa,
                'itens' => [],
                'total' => 0 // opcional (se tiver preço)
            ];
        }

        // percorre itens do pedido
        foreach ($pedido['itens'] as $item) {

            $nome = $item['nome'];

            // se item ainda não existe na comanda
            if (!isset($comandas[$mesa]['itens'][$nome])) {
                $comandas[$mesa]['itens'][$nome] = [
                    'nome' => $nome,
                    'quantidade' => 0,
                    'subtotal' => 0 // opcional
                ];
            }

            // soma quantidade
            $comandas[$mesa]['itens'][$nome]['quantidade'] += $item['quantidade'];

            //se tiver preço no item
            if (isset($item['preco'])) {
                $subtotal = $item['quantidade'] * $item['preco'];

                $comandas[$mesa]['itens'][$nome]['subtotal'] += $subtotal;
                $comandas[$mesa]['total'] += $subtotal;
            }
        }
    }

    // ordena por número da mesa
    ksort($comandas);

    $comandasFechadas = $_SESSION['comandasFechadas'] ?? [];


    require VIEWS . 'ComandasView.php';
}

// function fecharComanda(): void
// {
//     session_start();

//     $mesa = $_POST['mesa'] ?? null;

//     if (!$mesa) {
//         header("Location: " . BASE_URL . "?rota=comandas");
//         exit;
//     }

//     $_SESSION['comandas'] = $_SESSION['comandas'] ?? [];
//     $_SESSION['comandasFechadas'] = $_SESSION['comandasFechadas'] ?? [];
//     $_SESSION['mesas'] = $_SESSION['mesas'] ?? [];

//     foreach ($_SESSION['comandas'] as $key => $comanda) {

//         if ($comanda['mesa'] == $mesa) {

//             // move pra fechadas
//             $_SESSION['comandasFechadas'][] = $comanda;

//             // remove das abertas
//             unset($_SESSION['comandas'][$key]);
//         }
//     }

//     //libera a mesa
//     foreach ($_SESSION['mesas'] as &$mesaItem) {
//         if ($mesaItem['numero'] == $mesa) {
//             $mesaItem['status'] = 'livre';
//         }
//     }

//     header("Location: " . BASE_URL . "?rota=comandas");
//     exit;
// }