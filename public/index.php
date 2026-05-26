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

$rotas = [
    '/'                         => ['GET',  'LoginController',        'index'],
    '/login'                    => ['GET',  'LoginController',        'index'],
    '/login/entrar'             => ['POST', 'LoginController',        'login'],
    '/logout'                   => ['GET',  'LoginController',        'logout'],
    '/mesas'                    => ['GET',  'MesasController',        'index'],
    '/mesas/cadastrar'          => ['POST', 'MesasController',        'cadastrar'],
    '/mesas/alterarStatus'      => ['POST', 'MesasController',        'alterarStatus'],
    '/mesas/excluir'            => ['POST', 'MesasController',        'excluir'],
    '/pedidos'                  => ['GET',  'PedidosController',      'index'],
    '/pedidos/cadastrar'        => ['POST', 'PedidosController',      'cadastrar'],
    '/pedidos/alterarStatus'    => ['POST', 'PedidosController',      'alterarStatus'],
    '/funcionarios'             => ['GET',  'FuncionariosController', 'index'],
    '/funcionarios/cadastrar'   => ['POST', 'FuncionariosController', 'cadastrar'],
    '/funcionarios/excluir'     => ['POST', 'FuncionariosController', 'excluir'],
    '/comandas'                 => ['GET',  'ComandasController',     'index'],
    '/comandas/fechar'          => ['POST', 'ComandasController',     'fechar'],
];

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = rtrim($url, '/') ?: '/';
$metodo = $_SERVER['REQUEST_METHOD'];

if (array_key_exists($url, $rotas) && $rotas[$url][0] === $metodo) {
    [, $controller, $acao] = $rotas[$url];
    $controller::$acao();
} else {
    http_response_code(404);
    echo 'Erro 404! Página não existe.';
}