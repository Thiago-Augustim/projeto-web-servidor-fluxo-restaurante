<?php

class FuncionariosController {
    use RespostaController;

    public static function index(): void
    {
        if (!isset($_SESSION['logado'])) {
            self::redirecionar('login');
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
            self::redirecionar('funcionarios', null, $erros);
        }

        $model = new FuncionarioModel();

        if (empty($usuarioInput)) {
            $usuario = self::gerarUsuarioUnico($nome);
        } else {
            $usuario = strtolower($usuarioInput);

            if (!preg_match('/^[a-z0-9\.]+$/', $usuario)) {
                self::redirecionar('funcionarios', null, ['Usuário inválido (use apenas letras, números e ponto).']);
            }

            if ($model->verificarUsuarioExistente($usuario)) {
                self::redirecionar('funcionarios', null, ['Usuário já cadastrado.']);
            }
        }

        try {
            $model->inserir($nome, $usuario, $especialidade, $senha);
            $_SESSION['sucesso'] = 'Funcionário cadastrado com sucesso.';
        } catch (Exception $e) {
            $_SESSION['erros'] = ['Erro ao cadastrar funcionário.'];
        }

        self::redirecionar('funcionarios');
    }

    public static function excluir(): void
    {
        $id = $_POST['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            self::redirecionar('funcionarios', null, ['ID inválido.']);
        }

        $model       = new FuncionarioModel();
        $funcionario = $model->buscarPorId((int) $id);

        if (!$funcionario) {
            self::redirecionar('funcionarios', null, ['Funcionário não encontrado.']);
        }

        if (isset($_SESSION['funcionarioLogado']['id']) && (int) $_SESSION['funcionarioLogado']['id'] === (int) $id) {
            self::redirecionar('funcionarios', null, ['Você não pode excluir o seu próprio usuário.']);
        }

        try {
            $model->deletar((int) $id);
            $_SESSION['sucesso'] = 'Funcionário excluído com sucesso.';
        } catch (Exception $e) {
            $_SESSION['erros'] = ['Erro ao excluir funcionário.'];
        }

        self::redirecionar('funcionarios');
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
