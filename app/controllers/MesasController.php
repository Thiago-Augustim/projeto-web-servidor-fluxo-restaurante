<?php
require_once MIDDLEWARES . 'Auth.php';
require_once MODELS . 'MesaModel.php';
require_once MODELS . 'ComandaModel.php';

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

    try {
        $comandaModel = new ComandaModel();

        // Verifica se tem comanda aberta
        if ($comandaModel->existeComandaAberta($numeroMesa)) {
            // Busca todos os pedidos da mesa
            $pedidos = Pedidos::buscarPorMesa($numeroMesa);

            // Verifica se todos os pedidos estão cancelados
            $todosCancelados = true;
            foreach ($pedidos as $pedido) {
                if ($pedido['status'] !== 'cancelado') {
                    $todosCancelados = false;
                    break;
                }
            }

            // Se não estão todos cancelados, bloqueia
            if (!$todosCancelados) {
                $_SESSION['erros'] = ["Esta mesa possui uma comanda aberta com pedidos ativos. Feche a comanda antes de alterar o status."];
                header('Location: ' . BASE_URL . '?rota=mesas');
                exit();
            }

            // Se todos estão cancelados, deleta a comanda
            $comandaModel->deletarPorMesa($numeroMesa);
        }

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
        $comandaModel = new ComandaModel();

        $mesa = $mesaModel->buscarPorNumero($numeroMesa);

        if (!$mesa) {
            $_SESSION['erros'] = ["Mesa não encontrada"];
            header('Location: ' . BASE_URL . '?rota=mesas');
            exit();
        }

        // Valida se tem comanda aberta
        if ($comandaModel->existeComandaAberta($numeroMesa)) {
            $_SESSION['erros'] = ["Não é possível excluir uma mesa com comanda aberta. Feche a comanda primeiro."];
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
