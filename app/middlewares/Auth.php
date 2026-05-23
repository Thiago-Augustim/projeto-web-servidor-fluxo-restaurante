<?php

class Auth {
    private static array $permissoes = [
        'garcom'  => ['mesas', 'pedidos', 'comandas'],
        'cozinha' => ['pedidos'],
        'gerente' => ['mesas', 'pedidos', 'comandas', 'funcionarios', 'relatorios'],
        'admin'   => ['mesas', 'pedidos', 'comandas', 'funcionarios', 'relatorios'],
    ];

    public static function validarAcesso(): void
    {
        $rota  = $_GET['rota'] ?? '';
        $cargo = $_SESSION['usuarioEspecialidade'] ?? '';
        $rotasPermitidas = self::$permissoes[$cargo] ?? [];

        if (in_array($rota, $rotasPermitidas)) {
            return;
        }

        $rotaRedirecionada = $rotasPermitidas[0] ?? 'login';
        $_SESSION['erros'][] = "Seu cargo {$cargo} não tem acesso à tela de {$rota}.";
        header("Location: " . BASE_URL . "?rota=" . $rotaRedirecionada);
        exit();
    }

    public static function permiteMenu(string $rota): bool
    {
        $cargo = $_SESSION['usuarioEspecialidade'] ?? '';
        return in_array($rota, self::$permissoes[$cargo] ?? []);
    }
}
