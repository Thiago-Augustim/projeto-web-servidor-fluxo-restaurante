<?php
require_once MIDDLEWARES . 'Auth.php';
require_once MODELS . 'ComandaModel.php';
require_once MODELS . 'MesaModel.php';

function comandasIndex(): void
{
    if (!isset($_SESSION['logado'])) {
        header("Location: " . BASE_URL . "?rota=login");
        exit();
    }

    global $permissoes;
    validarAcesso($permissoes);

    $comandaModel = new ComandaModel();
    $pedidos = Pedidos::todos();
    $comandas = [];

    // Calcula comandas ativas a partir dos pedidos (sem pedidos cancelados)
    foreach ($pedidos as $pedido) {
        $mesa = $pedido['numeroMesa'];

        // Ignora pedidos cancelados
        if ($pedido['status'] === 'cancelado') {
            continue;
        }

        if (!isset($comandas[$mesa])) {
            $comandas[$mesa] = [
                'mesa' => $mesa,
                'itens' => [],
                'total' => 0
            ];
        }

        foreach ($pedido['itens'] as $item) {
            $nome = $item['nome'];

            if (!isset($comandas[$mesa]['itens'][$nome])) {
                $comandas[$mesa]['itens'][$nome] = [
                    'nome' => $nome,
                    'quantidade' => 0,
                    'subtotal' => 0
                ];
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

function fecharComanda(): void
{
    $mesa = $_POST['mesa'] ?? null;

    if (!$mesa) {
        $_SESSION['erros'] = ['Selecione uma comanda para finalizar'];
        header("Location: " . BASE_URL . "?rota=comandas");
        exit();
    }

    try {
        $comandaModel = new ComandaModel();
        $mesaModel = new MesaModel();

        // Busca todos os pedidos da mesa
        $pedidos = Pedidos::buscarPorMesa($mesa);

        // Valida se todos os pedidos (não cancelados) estão concluídos
        $temPendente = false;
        foreach ($pedidos as $pedido) {
            if ($pedido['status'] !== 'concluido' && $pedido['status'] !== 'cancelado') {
                $temPendente = true;
                break;
            }
        }

        if ($temPendente) {
            $_SESSION['erros'] = ['Há pedidos que não foram concluídos. Todos devem estar concluídos para fechar a comanda!'];
            header("Location: " . BASE_URL . "?rota=comandas");
            exit();
        }

        // Gera comanda fechada (sem pedidos cancelados)
        $comandaFechada = $comandaModel->gerarComandaFechada($mesa);

        // Salva comanda fechada
        $comandaModel->salvarFechada($mesa, $comandaFechada['itens'], $comandaFechada['total']);

        // Deleta comanda aberta
        $comandaModel->deletarPorMesa($mesa);

        // Deleta pedidos da mesa
        foreach ($pedidos as $pedido) {
            Pedidos::deletar($pedido['id']);
        }

        // Libera mesa
        $mesaModel->atualizarStatus($mesa, 'livre');

        $_SESSION['sucesso'] = "Comanda fechada com sucesso!";
    } catch (Exception $e) {
        $_SESSION['erros'] = [$e->getMessage()];
    }

    header("Location: " . BASE_URL . "?rota=comandas");
    exit;
}
