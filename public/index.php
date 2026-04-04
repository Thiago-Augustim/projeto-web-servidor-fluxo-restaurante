<?php


define('ROOT', __DIR__ . '/../');
define('VIEWS', ROOT . 'app/Views/');
define('MODELS', ROOT . 'app/models/');
define('BASE_URL', '/projeto-fluxo-restaurante/public/index.php');
define('CONTROLLERS', ROOT . 'app/controllers/');

require CONTROLLERS . 'MesasController.php';
require CONTROLLERS . 'FuncionariosController.php';

session_start();


$rota = $_GET['rota'] ?? 'mesas';
$acao = $_GET['acao'] ?? 'index';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($rota === 'mesas' && $acao === 'cadastrar') {
        cadastrarMesa();
    }
}

match($rota) {
    'mesas' => mesasIndex(),
    'funcionarios' => funcionariosIndex(),
    default => mesasIndex(),
};








