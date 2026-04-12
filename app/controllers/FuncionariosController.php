<?php

function funcionariosIndex(): void
{
    if(!isset($_SESSION['logado'])){
        header("Location: " . BASE_URL . "?rota=login");
        exit();
    }

    if (!isset($_SESSION['funcionarios'])) {
        $_SESSION['funcionarios'] = require MODELS . 'Funcionarios.php';
    }

    $funcionarios = $_SESSION['funcionarios'];

    require VIEWS . 'FuncionariosView.php';
}


function gerarUsuario($nome) {
    $nome = strtolower(trim($nome));
    $nome = iconv('UTF-8', 'ASCII//TRANSLIT', $nome);
    $nome = preg_replace('/[^a-zA-Z0-9\s]/', '', $nome);

    $partes = array_values(array_filter(explode(' ', $nome)));

    if (count($partes) >= 2) {
        return $partes[0] . '.' . end($partes);
    }

    return $partes[0] ?? 'usuario';
}

function usuarioExiste($usuario, $funcionarios) {
    foreach ($funcionarios as $f) {
        if (isset($f['usuario']) && $f['usuario'] === $usuario) {
            return true;
        }
    }
    return false;
}

function gerarUsuarioUnico($nome, $funcionarios) {
    $base = gerarUsuario($nome);
    $usuario = $base;
    $i = 1;

    while (usuarioExiste($usuario, $funcionarios)) {
        $usuario = $base . $i;
        $i++;
    }

    return $usuario;
}

function cadastrarFuncionario(): void
{
    $nome = $_POST['nome'] ?? null;
    $especialidade = $_POST['especialidade'] ?? null;
    $senha = $_POST['senha'] ?? null;
    $usuarioInput = $_POST['usuario'] ?? '';

    if (!$nome || !$especialidade || !$senha) {
        $_SESSION['erros'] = ['Preencha todos os campos'];
        header("Location: " . BASE_URL . "?rota=funcionarios");
        exit;
    }

    if (!isset($_SESSION['funcionarios'])) {
        $_SESSION['funcionarios'] = require MODELS . 'Funcionarios.php';
    }

    $funcionarios = $_SESSION['funcionarios'];

    if (empty($usuarioInput)) {
        $usuario = gerarUsuarioUnico($nome, $funcionarios);
    } else {
        // valida formato básico
        $usuario = strtolower(trim($usuarioInput));

        if (!preg_match('/^[a-z0-9\.]+$/', $usuario)) {
            $_SESSION['erros'] = ['Usuário inválido (use apenas letras, números e ponto)'];
            header("Location: " . BASE_URL . "?rota=funcionarios");
            exit;
        }

        // verifica duplicado
        if (usuarioExiste($usuario, $funcionarios)) {
            $_SESSION['erros'] = ['Usuário já existe'];
            header("Location: " . BASE_URL . "?rota=funcionarios");
            exit;
        }
    }

    $novoId = count($funcionarios) + 1;

    $funcionarios[] = [
        'id' => $novoId,
        'nome' => $nome,
        'usuario' => $usuario, 
        'especialidade' => $especialidade,
        'senha' => password_hash($senha, PASSWORD_DEFAULT)
    ];

    $_SESSION['funcionarios'] = $funcionarios;

    header("Location: " . BASE_URL . "?rota=funcionarios");
    exit;
}

function excluirFuncionario(): void
{
    $id = $_POST['id'] ?? null;

    if (!$id) {
        $_SESSION['erros'] = ['ID inválido'];
        header("Location: " . BASE_URL . "?rota=funcionarios");
        exit;
    }

    if (!isset($_SESSION['funcionarios'])) {
        header("Location: " . BASE_URL . "?rota=funcionarios");
        exit;
    }

    $funcionarios = $_SESSION['funcionarios'];

    // filtra removendo o funcionário
    $funcionarios = array_filter($funcionarios, function ($f) use ($id) {
        return $f['id'] != $id;
    });

    // reindexa array (pra não ficar com buraco tipo [0,1,4,7])
    $funcionarios = array_values($funcionarios);

    $_SESSION['funcionarios'] = $funcionarios;

    header("Location: " . BASE_URL . "?rota=funcionarios");
    exit;
}