<?php
define('ROOT', __DIR__ . '/../');
define('VIEWS', ROOT . 'src/Views/');
define('MODELS', ROOT . 'src/models/');
define('BASE_URL', '/projeto-fluxo-restaurante/public/index.php?');

session_start();

$rota = $_GET['rota'] ?? 'mesas';

match($rota) {
    'mesas'      => require VIEWS . 'mesas.view.php',
    'pedidos'    => require VIEWS . 'pedidos.view.php',
    'cardapio'   => require VIEWS . 'cardapio.view.php',
    'comandas'   => require VIEWS . 'comandas.view.php',
    'garcons'    => require VIEWS . 'garcons.view.php',
    'relatorios' => require VIEWS . 'relatorios.view.php',
    default      => require VIEWS . 'mesas.view.php',
};

