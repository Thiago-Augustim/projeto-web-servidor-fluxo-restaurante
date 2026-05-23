<?php

function loginIndex(): void
{
    if (isset($_SESSION['logado']) && $_SESSION['logado'] === "true") {
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }
    require VIEWS . 'LoginView.php';
}

function login(): void
{
    $usuario = $_POST['usuario'] ?? '';
    $senha   = $_POST['senha'] ?? '';

    if ($usuario === 'admin' && $senha === 'admin') {
        $_SESSION['logado']               = "true";
        $_SESSION['pedidos']              = null;
        $_SESSION['usuarioEspecialidade'] = 'admin';
        $_SESSION['funcionarioLogado']    = [
            'id'            => 0,
            'nome'          => 'Administrador',
            'usuario'       => 'admin',
            'especialidade' => 'admin',
        ];
        header('Location: ' . BASE_URL . '?rota=mesas');
        exit();
    }

    $erros = validarLogin($usuario, $senha);

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        header('Location: ' . BASE_URL . '?rota=login');
        exit();
    }

    $model       = new FuncionarioModel();
    $funcionario = $model->buscarPorUsuario($usuario);

    if ($funcionario && password_verify($senha, $funcionario['senha'])) {
        $_SESSION['funcionarioLogado'] = [
            'id'            => $funcionario['id'],
            'nome'          => $funcionario['nome'],
            'usuario'       => $funcionario['usuario'],
            'especialidade' => $funcionario['especialidade'],
        ];
        $_SESSION['logado']               = "true";
        $_SESSION['pedidos']              = null;
        $_SESSION['usuarioEspecialidade'] = $funcionario['especialidade'];

        if ($funcionario['especialidade'] === 'cozinha') {
            header('Location: ' . BASE_URL . '?rota=pedidos');
        } else {
            header('Location: ' . BASE_URL . '?rota=mesas');
        }
        exit();
    }

    $_SESSION['erros'] = ['Usuário ou senha inválidos.'];
    header('Location: ' . BASE_URL . '?rota=login');
    exit();
}

function logout(): void
{
    session_destroy();
    header('Location: ' . BASE_URL . '?rota=login');
    exit();
}

function validarLogin(string $usuario, string $senha): array
{
    $erros = [];

    if (empty($usuario)) {
        $erros[] = 'O campo usuário é obrigatório.';
    }

    if (empty($senha)) {
        $erros[] = 'O campo senha é obrigatório.';
    }

    return $erros;
}
