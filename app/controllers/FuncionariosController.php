<?php

require_once MIDDLEWARES . 'Auth.php';

function funcionariosIndex(): void
{
    if (!isset($_SESSION['logado'])) {
        header("Location: " . BASE_URL . "?rota=login");
        exit();
    }

    global $permissoes;
    validarAcesso($permissoes);

    $model = new FuncionarioModel();
    $funcionarios = $model->listar();

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

function gerarUsuarioUnico($nome) {
    $model = new FuncionarioModel();
    $base  = gerarUsuario($nome);
    $usuario = $base;
    $i = 1;
    while ($model->verificarUsuarioExistente($usuario)) {
        $usuario = $base . $i;
        $i++;
    }
    return $usuario;
}

function validarFuncionario($nome, $especialidade, $senha): array
{
    $erros = [];
    $especialidadesValidas = ['garcom', 'cozinha', 'gerente'];

    if (empty(trim($nome))) {
        $erros[] = 'O nome é obrigatório.';
    } elseif (strlen(trim($nome)) < 3) {
        $erros[] = 'O nome deve ter ao menos 3 caracteres.';
    }

    if (empty($especialidade) || !in_array($especialidade, $especialidadesValidas)) {
        $erros[] = 'Especialidade inválida.';
    }

    if (empty($senha)) {
        $erros[] = 'A senha é obrigatória.';
    } elseif (strlen($senha) < 6) {
        $erros[] = 'A senha deve ter ao menos 6 caracteres.';
    }

    return $erros;
}

function cadastrarFuncionario(): void
{
    $nome          = trim($_POST['nome'] ?? '');
    $especialidade = $_POST['especialidade'] ?? '';
    $senha         = $_POST['senha'] ?? '';
    $usuarioInput  = trim($_POST['usuario'] ?? '');

    $erros = validarFuncionario($nome, $especialidade, $senha);

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        header("Location: " . BASE_URL . "?rota=funcionarios");
        exit();
    }

    $model = new FuncionarioModel();

    if (empty($usuarioInput)) {
        $usuario = gerarUsuarioUnico($nome);
    } else {
        $usuario = strtolower($usuarioInput);

        if (!preg_match('/^[a-z0-9\.]+$/', $usuario)) {
            $_SESSION['erros'] = ['Usuário inválido (use apenas letras, números e ponto).'];
            header("Location: " . BASE_URL . "?rota=funcionarios");
            exit();
        }

        if ($model->verificarUsuarioExistente($usuario)) {
            $_SESSION['erros'] = ['Usuário já cadastrado.'];
            header("Location: " . BASE_URL . "?rota=funcionarios");
            exit();
        }
    }

    try {
        $model->inserir($nome, $usuario, $especialidade, $senha);
        $_SESSION['sucesso'] = 'Funcionário cadastrado com sucesso.';
    } catch (Exception $e) {
        $_SESSION['erros'] = ['Erro ao cadastrar funcionário.'];
    }

    header("Location: " . BASE_URL . "?rota=funcionarios");
    exit();
}

function excluirFuncionario(): void
{
    $id = $_POST['id'] ?? null;

    if (!$id || !is_numeric($id)) {
        $_SESSION['erros'] = ['ID inválido.'];
        header("Location: " . BASE_URL . "?rota=funcionarios");
        exit();
    }

    $model       = new FuncionarioModel();
    $funcionario = $model->buscarPorId((int) $id);

    if (!$funcionario) {
        $_SESSION['erros'] = ['Funcionário não encontrado.'];
        header("Location: " . BASE_URL . "?rota=funcionarios");
        exit();
    }

    if (isset($_SESSION['funcionarioLogado']['id']) && (int) $_SESSION['funcionarioLogado']['id'] === (int) $id) {
        $_SESSION['erros'] = ['Você não pode excluir o seu próprio usuário.'];
        header("Location: " . BASE_URL . "?rota=funcionarios");
        exit();
    }

    try {
        $model->deletar((int) $id);
        $_SESSION['sucesso'] = 'Funcionário excluído com sucesso.';
    } catch (Exception $e) {
        $_SESSION['erros'] = ['Erro ao excluir funcionário.'];
    }

    header("Location: " . BASE_URL . "?rota=funcionarios");
    exit();
}
