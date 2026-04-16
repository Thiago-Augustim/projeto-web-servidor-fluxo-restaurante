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

        //ignora pedidos cancelados
        if ($pedido['status'] === 'cancelado') {
            continue;
        }

        // cria a comanda da mesa se não existir
        if (!isset($comandas[$mesa])) {
            $comandas[$mesa] = [
                'mesa' => $mesa,
                'itens' => [],
                'total' => 0 
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
                    'subtotal' => 0 
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

function fecharComanda(): void
{
    $mesa = $_POST['mesa'] ?? null;

    if (!$mesa) {
        $_SESSION['erros'] = ['Selecione uma comanda para finalizar'];
        header("Location: " . BASE_URL . "?rota=comandas");
        exit();
    }

    $_SESSION['pedidos'] = $_SESSION['pedidos'] ?? [];
    //$_SESSION['comandasFechadas'] = $_SESSION['comandasFechadas'] ?? [];
    $_SESSION['mesas'] = $_SESSION['mesas'] ?? [];

    // salvar comanda antes de apagar 
    $comandaFechada = [
        'mesa' => $mesa,
        'itens' => [],
        'total' => 0
    ];

    // percorre pedidos pra montar histórico
    foreach ($_SESSION['pedidos'] as $pedido) {

        if ($pedido['numeroMesa'] != $mesa || $pedido['status'] === 'cancelado') {
            continue;
        }

        //Verifica se todos os pedidos das comandas foram concluidos
        if ($pedido['status'] != 'concluido' && $pedido['status'] != 'cancelado') {
            $_SESSION['erros'] = ['Há pedidos que não foram concluidos na mesa ' . $pedido['numeroMesa'] . '. Todos deves estar concluidos para fechar a comanda!'];
            header("Location: " . BASE_URL . "?rota=comandas"); 
            exit();
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

    // salva nas fechadas
    $_SESSION['comandasFechadas'][] = $comandaFechada;

    //REMOVE TODOS OS PEDIDOS DA MESA
    $_SESSION['pedidos'] = array_filter($_SESSION['pedidos'], function ($pedido) use ($mesa) {
        return $pedido['numeroMesa'] != $mesa;
    });

    //libera mesa
    foreach ($_SESSION['mesas'] as &$mesaItem) {
        if ($mesaItem['numero'] == $mesa) {
            $mesaItem['status'] = 'livre';
        }
    }

    header("Location: " . BASE_URL . "?rota=comandas");
    exit;
}
