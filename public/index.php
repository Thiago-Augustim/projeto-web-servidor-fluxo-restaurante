<?php
define('ROOT', __DIR__ . '/../');
define('VIEWS', ROOT . 'app/Views/');
define('MODELS', ROOT . 'app/models/');
define('DATABASE', ROOT . 'database/');
define('BASE_URL', 'http://projeto-fluxo-restaurante.test/');
define('CONTROLLERS', ROOT . 'app/controllers/');
define('MIDDLEWARES', ROOT . 'app/middlewares/');

require ROOT . 'vendor/autoload.php';

session_start();

$rota = $_GET['rota'] ?? 'login';
$acao = $_GET['acao'] ?? 'index';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    match (true) {
        $rota === 'mesas' && $acao === 'cadastrar' => MesasController::cadastrar(),
        $rota === 'mesas' && $acao === 'alterarStatusMesa' => MesasController::alterarStatus(),
        $rota === 'mesas' && $acao === 'excluirMesa' => MesasController::excluir(),
        $rota === 'funcionarios' && $acao === 'cadastrar' => FuncionariosController::cadastrar(),
        $rota === 'funcionarios' && $acao === 'excluir'=> FuncionariosController::excluir(),
        $rota === 'login' && $acao === 'entrar' => LoginController::login(),
        $rota === 'pedidos' && $acao === 'cadastrar' => PedidosController::cadastrar(),
        $rota === 'pedidos' && $acao === 'alterarStatus' => PedidosController::alterarStatus(),
        $rota === 'comandas' && $acao === 'fechar' => ComandasController::fechar(),
        default => null,
    };
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $rota === 'logout') {
    LoginController::logout();
}

match ($rota) {
    'login' => LoginController::index(),
    'mesas' => MesasController::index(),
    'funcionarios' => FuncionariosController::index(),
    'pedidos' => PedidosController::index(),
    'comandas' => ComandasController::index(),
    default => MesasController::index(),
};
