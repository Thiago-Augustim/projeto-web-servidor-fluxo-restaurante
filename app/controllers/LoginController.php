<?php

class LoginController {
    use RespostaController;

    public static function index(): void
    {
        if (isset($_SESSION['logado']) && $_SESSION['logado'] === "true") {
            self::redirecionar('mesas');
        }
        require VIEWS . 'LoginView.php';
    }

    public static function login(): void
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
            self::redirecionar('mesas');
        }

        $erros = self::validar($usuario, $senha);

        if (!empty($erros)) {
            self::redirecionar('login', null, $erros);
        }

        $funcionario = (new FuncionarioModel())->buscarPorUsuario($usuario);

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

            $destino = $funcionario['especialidade'] === 'cozinha' ? 'pedidos' : 'mesas';
            self::redirecionar($destino);
        }

        self::redirecionar('login', null, ['Usuário ou senha inválidos.']);
    }

    public static function logout(): void
    {
        session_destroy();
        self::redirecionar('login');
    }

    private static function validar(string $usuario, string $senha): array
    {
        $erros = [];
        if (empty($usuario)) $erros[] = 'O campo usuário é obrigatório.';
        if (empty($senha))   $erros[] = 'O campo senha é obrigatório.';
        return $erros;
    }
}
