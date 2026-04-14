<?php
define('ROOT', __DIR__ . '/../');
define('VIEWS', ROOT . 'app/Views/');
define('MODELS', ROOT . 'app/models/');
define('BASE_URL', '/projeto-fluxo-restaurante/public/index.php');
define('CONTROLLERS', ROOT . 'app/controllers/');
define('MIDDLEWARES', ROOT . 'app/middlewares/');

require CONTROLLERS . 'MesasController.php';
require CONTROLLERS . 'LoginController.php';
require CONTROLLERS . 'FuncionariosController.php';
require CONTROLLERS . 'PedidosController.php';
require CONTROLLERS . 'ComandasController.php';

session_start();

$rota = $_GET['rota'] ?? 'login';
$acao = $_GET['acao'] ?? 'index';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($rota === 'mesas' && $acao === 'cadastrar') {
        cadastrarMesa();
    }
    if($rota === 'mesas' && $acao === 'alterarStatusMesa') {
        alterarStatusMesa();
    }
    if($rota ==='mesas' && $acao === 'excluirMesa'){
        excluirMesa();
    }
    if ($rota === 'funcionarios' && $acao === 'cadastrar') {
        cadastrarFuncionario();
    }
    if ($rota === 'funcionarios' && $acao === 'excluir') {
        excluirFuncionario();
    }
    if ($rota === 'login' && $acao === 'entrar') {
        login();
    }
    if($rota === 'pedidos' && $acao === 'cadastrar') {
    cadastrarPedido();
    }
    if ($rota === 'pedidos' && $acao === 'alterarStatus') {
    alterarStatusPedido();
    }

}

if($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($rota === 'logout') {
        logout();
    }

}

match($rota) {
    'login' => loginIndex(),
    'mesas' => mesasIndex(),
    'funcionarios' => funcionariosIndex(),
    'pedidos' => pedidosIndex(),
    'comandas' => comandasIndex(),
    default => mesasIndex(),
};