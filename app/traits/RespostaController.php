<?php

trait RespostaController {
    private static function redirecionar(string $rota, ?string $sucesso = null, ?array $erros = null): void
    {
        if ($sucesso !== null) {
            $_SESSION['sucesso'] = $sucesso;
        }
        if ($erros !== null) {
            $_SESSION['erros'] = $erros;
        }
        header('Location: ' . BASE_URL . $rota);
        exit();
    }
}