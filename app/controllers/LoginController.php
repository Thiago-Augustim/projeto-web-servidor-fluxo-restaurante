<?php

function loginIndex(): void
{

    //Verifica se a sessão de funcionários existe, se não existir, carrega os dados do arquivo e salva na sessão
    if (!isset($_SESSION['funcionarios']) || empty($_SESSION['funcionarios'])) {
        $_SESSION['funcionarios'] = require MODELS . 'Funcionarios.php';
    }

    //Se o funcionário já estiver logado, redireciona para a página de mesas
    if ((isset($_SESSION['logado']) ) && $_SESSION['logado'] === "true") {
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }
    require VIEWS . 'LoginView.php';
}

function login(): void
{
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $erros = validarLogin($usuario, $senha);

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        header('Location: ' . BASE_URL . '?rota=login');
        exit();
    }

    $funcionarios = $_SESSION['funcionarios'] ?? [];

    $funcionarioEncontrado = null;
    foreach ($funcionarios as $funcionario) {
        if ($funcionario['usuario'] === $usuario && password_verify($senha, $funcionario['senha'])) {
            $funcionarioEncontrado = $funcionario;
            break;
        }
    }
    if ($funcionarioEncontrado) {
        $_SESSION['funcionarioLogado'] = $funcionarioEncontrado;
        $_SESSION['logado'] = "true";
        $_SESSION['pedidos'] = null;
        $_SESSION['usuarioEspecialidade'] = $funcionarioEncontrado['especialidade'];

            if($funcionarioEncontrado['especialidade'] === 'garcom'){
                header('Location: ' . BASE_URL . '?rota=mesas');
            }
            if($funcionarioEncontrado['especialidade'] === 'cozinha'){
                header('Location: ' . BASE_URL . '?rota=pedidos');
            }
            if($funcionarioEncontrado['especialidade'] === 'gerente'){
                header('Location: ' . BASE_URL . '?rota=mesas');
            }
        
        exit();
    } else {
        $_SESSION['erros'] = ['usuario ou senha inválidos.'];
        header('Location: ' . BASE_URL . '?rota=login');
        exit();
    }
}

function logout(): void
{

    //$funcionarios = $_SESSION['funcionarios'] ?? null;
    //$mesas = $_SESSION['mesas'] ?? null;
    //$funcionarioLogado = $_SESSION['funcionarioLogado'] ?? null;

    session_destroy();
    //session_start();

    //$_SESSION['funcionarios'] = $funcionarios;
    //$_SESSION['mesas'] = $mesas;
    //$_SESSION['funcionarioLogado'] = $funcionarioLogado;

    header('Location: ' . BASE_URL . '?rota=login');
    exit();
}



function validarLogin(string $usuario, string $senha): array
{
    $erros = [];

    if (empty($usuario)) {
        $erros[] = 'O campo usuario é obrigatório.';
    }

    if (empty($senha)) {
        $erros[] = 'O campo senha é obrigatório.';
    }

    return $erros;
}
