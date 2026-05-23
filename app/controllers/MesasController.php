<?php
require_once MIDDLEWARES . 'Auth.php';
require_once MODELS . 'MesaModel.php';

function mesasIndex(): void
{
    if (!isset($_SESSION['logado'])) {
        header("Location: " . BASE_URL . "?rota=login");
        exit();
    }

    global $permissoes;
    validarAcesso($permissoes);

    $mesaModel = new MesaModel();
    $mesas = $mesaModel->listar();

    require VIEWS . 'MesasView.php';
}



function cadastrarMesa(): void
{
    $numero = $_POST['numero'] ?? null;
    $cadeiras = $_POST['cadeiras'] ?? null;
    $status = $_POST['status'] ?? null;

    $erros = validarMesa($_POST);

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }

    try {
        $mesaModel = new MesaModel();
        $mesaModel->inserir($numero, $cadeiras, $status);
        $_SESSION['sucesso'] = "Mesa cadastrada com sucesso!";
    } catch (Exception $e) {
        $_SESSION['erros'] = [$e->getMessage()];
    }

    header('Location: ' . BASE_URL . '?rota=mesas');
    exit();
}

function validarMesa($mesa): array
{
    $erros = [];
    $mesaModel = new MesaModel();

    if (empty($mesa['numero'])) {
        $erros[] = "Número da mesa é obrigatório.";
    } elseif (!is_numeric($mesa['numero']) || $mesa['numero'] < 1) {
        $erros[] = "Número da mesa inválido.";
    } else {
        if ($mesaModel->verificarNumeroExistente($mesa['numero'])) {
            $erros[] = "Número da mesa já existe.";
        }
    }

    if (empty($mesa['cadeiras'])) {
        $erros[] = "Quantidade de cadeiras é obrigatória.";
    } elseif (!is_numeric($mesa['cadeiras']) || $mesa['cadeiras'] < 1) {
        $erros[] = "Quantidade de cadeiras inválida.";
    }

    if (empty($mesa['status']) || !in_array($mesa['status'], ['livre', 'ocupada', 'reservada'])) {
        $erros[] = "Status da mesa inválido.";
    }

    return $erros;
}

function alterarStatusMesa()
{
    $numeroMesa = $_POST['numeroMesa'] ?? null;
    $status = $_POST['status'] ?? null;

    if (!$numeroMesa || !$status) {
        $_SESSION['erros'] = ["Selecione uma mesa para alterar o status."];
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }

    $pedidoPendente = false;
    if (isset($_SESSION['pedidos'])) {
        foreach ($_SESSION['pedidos'] as $pedido) {
            if ($pedido['numeroMesa'] == $numeroMesa && $pedido['status'] !== 'cancelado') {
                $pedidoPendente = true;
                break;
            }
        }
    }

    if ($pedidoPendente) {
        $_SESSION['erros'] = ["Esta mesa possui um pedido e comanda aberto, seu status não pode ser alterado"];
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }

    try {
        $mesaModel = new MesaModel();
        $mesaModel->atualizarStatus($numeroMesa, $status);
        $_SESSION['sucesso'] = "Status da mesa alterado para " . ucfirst($status) . ".";
    } catch (Exception $e) {
        $_SESSION['erros'] = [$e->getMessage()];
    }

    header('Location: ' . BASE_URL . '?rota=mesas');
    exit();
}

function excluirMesa(): void
{
    $numeroMesa = $_POST['numeroMesa'] ?? null;

    if (empty($numeroMesa)) {
        $_SESSION['erros'] = ["Selecione uma mesa antes de excluir"];
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }

    try {
        $mesaModel = new MesaModel();
        $mesa = $mesaModel->buscarPorNumero($numeroMesa);

        if (!$mesa) {
            $_SESSION['erros'] = ["Mesa não encontrada"];
            header('Location: ' . BASE_URL . '?rota=mesas');
            exit();
        }

        if ($mesa['status'] !== 'livre') {
            $_SESSION['erros'] = ["A mesa deve estar livre para ser excluída"];
            header('Location: ' . BASE_URL . '?rota=mesas');
            exit();
        }

        $mesaModel->deletar($mesa['id']);
        $_SESSION['sucesso'] = "Mesa excluída com sucesso!";
    } catch (Exception $e) {
        $_SESSION['erros'] = [$e->getMessage()];
    }

    header('Location: ' . BASE_URL . '?rota=mesas');
    exit();
}
