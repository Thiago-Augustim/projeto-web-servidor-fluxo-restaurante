<?php

class MesasController {
    use RespostaController;

    public static function index(): void
    {
        if (!isset($_SESSION['logado'])) {
            self::redirecionar('login');
        }

        Auth::validarAcesso();

        $mesas = (new MesaModel())->listar();

        require VIEWS . 'MesasView.php';
    }

    public static function cadastrar(): void
    {
        $erros = self::validar($_POST);

        if (!empty($erros)) {
            self::redirecionar('mesas', null, $erros);
        }

        try {
            (new MesaModel())->inserir($_POST['numero'], $_POST['cadeiras'], $_POST['status']);
            $_SESSION['sucesso'] = "Mesa cadastrada com sucesso!";
        } catch (Exception $e) {
            $_SESSION['erros'] = [$e->getMessage()];
        }

        self::redirecionar('mesas');
    }

    public static function alterarStatus(): void
    {
        $numeroMesa = $_POST['numeroMesa'] ?? null;
        $status     = $_POST['status']     ?? null;

        if (!$numeroMesa || !$status) {
            self::redirecionar('mesas', null, ["Selecione uma mesa para alterar o status."]);
        }

        try {
            $comandaModel = new ComandaModel();

            if ($comandaModel->existeComandaAberta($numeroMesa)) {
                $pedidos = Pedidos::buscarPorMesa($numeroMesa);
                $todosCancelados = array_reduce($pedidos, fn($carry, $p) => $carry && $p['status'] === 'cancelado', true);

                if (!$todosCancelados) {
                    self::redirecionar('mesas', null, ["Esta mesa possui uma comanda aberta com pedidos ativos. Feche a comanda antes de alterar o status."]);
                }

                $comandaModel->deletarPorMesa($numeroMesa);
            }

            (new MesaModel())->atualizarStatus($numeroMesa, $status);
            $_SESSION['sucesso'] = "Status da mesa alterado para " . ucfirst($status) . ".";
        } catch (Exception $e) {
            $_SESSION['erros'] = [$e->getMessage()];
        }

        self::redirecionar('mesas');
    }

    public static function excluir(): void
    {
        $numeroMesa = $_POST['numeroMesa'] ?? null;

        if (empty($numeroMesa)) {
            self::redirecionar('mesas', null, ["Selecione uma mesa antes de excluir."]);
        }

        try {
            $mesaModel    = new MesaModel();
            $comandaModel = new ComandaModel();
            $mesa         = $mesaModel->buscarPorNumero($numeroMesa);

            if (!$mesa) {
                self::redirecionar('mesas', null, ["Mesa não encontrada."]);
            }

            if ($comandaModel->existeComandaAberta($numeroMesa)) {
                self::redirecionar('mesas', null, ["Não é possível excluir uma mesa com comanda aberta."]);
            }

            if ($mesa['status'] !== 'livre') {
                self::redirecionar('mesas', null, ["A mesa deve estar livre para ser excluída."]);
            }

            $mesaModel->deletar($mesa['id']);
            $_SESSION['sucesso'] = "Mesa excluída com sucesso!";
        } catch (Exception $e) {
            $_SESSION['erros'] = [$e->getMessage()];
        }

        self::redirecionar('mesas');
    }

    private static function validar(array $dados): array
    {
        $erros     = [];
        $mesaModel = new MesaModel();

        if (empty($dados['numero'])) {
            $erros[] = "Número da mesa é obrigatório.";
        } elseif (!is_numeric($dados['numero']) || $dados['numero'] < 1) {
            $erros[] = "Número da mesa inválido.";
        } elseif ($mesaModel->verificarNumeroExistente($dados['numero'])) {
            $erros[] = "Número da mesa já existe.";
        }

        if (empty($dados['cadeiras'])) {
            $erros[] = "Quantidade de cadeiras é obrigatória.";
        } elseif (!is_numeric($dados['cadeiras']) || $dados['cadeiras'] < 1) {
            $erros[] = "Quantidade de cadeiras inválida.";
        }

        if (empty($dados['status']) || !in_array($dados['status'], ['livre', 'ocupada', 'reservada'])) {
            $erros[] = "Status da mesa inválido.";
        }

        return $erros;
    }
}
