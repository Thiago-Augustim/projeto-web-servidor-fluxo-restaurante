<?php


function mesasIndex(): void
{

    $mesas = require MODELS . 'Mesas.php';
    $mesasSessao = $_SESSION['mesas'] ?? [];

    $mesas = array_merge($mesas, $mesasSessao);

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

        // só verifica duplicidade do numero da mesa
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