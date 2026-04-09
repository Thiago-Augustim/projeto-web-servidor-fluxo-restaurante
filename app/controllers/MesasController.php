<?php


function mesasIndex(): void
{
    if (!isset($_SESSION['logado'])) {
        header("Location: " . BASE_URL . "?rota=login");
        exit();
    }

    //Se não haver uma sessão de mesas, ele carrega as mesas do arquivo e salva na sessão
    if (!isset($_SESSION['mesas'])) {
        $_SESSION['mesas'] = require MODELS . 'Mesas.php';
    }

    $mesas = $_SESSION['mesas'];

    require VIEWS . 'MesasView.php';
}


function cadastrarMesa(): void
{
    $mesas = require MODELS . 'Mesas.php';

    $numero = $_POST['numero'] ?? null;
    $cadeiras = $_POST['cadeiras'] ?? null;
    $status = $_POST['status'] ?? null;

    $mesasSessao = $_SESSION['mesas'] ?? [];

    $erros = validarMesa($_POST);

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }

    $mesasSessao[] = [
        'id' => count($mesas) + count($mesasSessao) + 1,
        'numero' => $numero,
        'cadeiras' => $cadeiras,
        'status' => $status
    ];
    $_SESSION['mesas'] = $mesasSessao;

    header('Location: ' . BASE_URL . '?rota=mesas');
    exit();
}

function validarMesa($mesa): array
{
    $erros = [];

    // verifica null/vazio 
    if (empty($mesa['numero'])) {
        $erros[] = "Número da mesa é obrigatório.";
    } elseif (!is_numeric($mesa['numero']) || $mesa['numero'] < 1) {
        $erros[] = "Número da mesa inválido.";
    } else {

        //verifica duplicidade do numero da mesa
        $mesas = require MODELS . 'Mesas.php';
        $mesasSessao = $_SESSION['mesas'] ?? [];
        $todasMesas = array_merge($mesas, $mesasSessao);

        foreach ($todasMesas as $m) {
            if ($m['numero'] == $mesa['numero']) {
                $erros[] = "Número da mesa já existe.";
                break;
            }
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

    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;



    if (!$id || !$status) {
        $_SESSION['erros'] = ["Selecione uma mesa para alterar o status."];
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }

    foreach ($_SESSION['mesas'] as &$mesa) {
        if ($mesa['id'] == $id) {
            $mesa['status'] = $status;
            $_SESSION['sucesso'] = "Status da mesa alterado para " . ucfirst($status) . ".";
            break;
        }
    }

    header('Location: ' . BASE_URL . '?rota=mesas');
    exit();
}

function excluirMesa(): void
{
    $id = $_POST['id'];

    if ($id === "") {
        $_SESSION['erros'][] = "Selecione uma mesa antes de exluir";
    }

    // Usamos $index => $mesa para pegar a posição exata no array
    foreach ($_SESSION['mesas'] as $index => $mesa) {
        if ($mesa['id'] == $id) {

            if ($mesa['status'] === 'livre') {
                unset($_SESSION['mesas'][$index]);
                break;
            } else {
                $_SESSION['erros'][] = "A mesa deve estar livre para ser Excluida";
                break;
            }

            //$_SESSION['mesas'] = array_values($_SESSION['mesas']);
        }
    }

    header('Location: ' . BASE_URL . '?rota=mesas');
    exit();
}
