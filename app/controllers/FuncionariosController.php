<?php

class FuncionariosController {
    public static function index(): void
    {
        if (!isset($_SESSION['logado'])) {
            header("Location: " . BASE_URL . "?rota=login");
            exit();
        }

        Auth::validarAcesso();

        $funcionarios = (new FuncionarioModel())->listar();

        require VIEWS . 'FuncionariosView.php';
    }

    public static function cadastrar(): void
    {
        $nome          = trim($_POST['nome']       ?? '');
        $especialidade = $_POST['especialidade']   ?? '';
        $senha         = $_POST['senha']           ?? '';
        $usuarioInput  = trim($_POST['usuario']    ?? '');

        $erros = self::validar($nome, $especialidade, $senha);

        if (!empty($erros)) {
            $_SESSION['erros'] = $erros;
            header("Location: " . BASE_URL . "?rota=funcionarios");
            exit();
        }

        $model = new FuncionarioModel();

        if (empty($usuarioInput)) {
            $usuario = self::gerarUsuarioUnico($nome);
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

    public static function excluir(): void
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

    private static function gerarUsuario(string $nome): string
    {
        $nome   = strtolower(trim($nome));
        $nome   = iconv('UTF-8', 'ASCII//TRANSLIT', $nome);
        $nome   = preg_replace('/[^a-zA-Z0-9\s]/', '', $nome);
        $partes = array_values(array_filter(explode(' ', $nome)));

        return count($partes) >= 2 ? $partes[0] . '.' . end($partes) : ($partes[0] ?? 'usuario');
    }

    private static function gerarUsuarioUnico(string $nome): string
    {
        $model   = new FuncionarioModel();
        $base    = self::gerarUsuario($nome);
        $usuario = $base;
        $i       = 1;

        while ($model->verificarUsuarioExistente($usuario)) {
            $usuario = $base . $i++;
        }

        return $usuario;
    }

    private static function validar(string $nome, string $especialidade, string $senha): array
    {
        $erros = [];

        if (empty(trim($nome))) {
            $erros[] = 'O nome é obrigatório.';
        } elseif (strlen(trim($nome)) < 3) {
            $erros[] = 'O nome deve ter ao menos 3 caracteres.';
        }

        if (!in_array($especialidade, ['garcom', 'cozinha', 'gerente'])) {
            $erros[] = 'Especialidade inválida.';
        }

        if (empty($senha)) {
            $erros[] = 'A senha é obrigatória.';
        } elseif (strlen($senha) < 6) {
            $erros[] = 'A senha deve ter ao menos 6 caracteres.';
        }

        return $erros;
    }
}
