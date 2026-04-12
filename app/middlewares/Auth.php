<?php
    
/*
Tipos de funcionario e acessos

Garçom - MESAS / pedidos / comandas
Cozinheiro - PEDIDOS 
gerente - todos os acessos

*/

$permissoes = [

    'garcom' => ['mesas', 'pedidos', 'comandas'],
    'cozinha'=> ['pedidos'],
    'gerente'=> ['mesas','pedidos', 'comandas','funcionarios','relatorios'],
];

function validarAcesso($permissoes) {

    $rota = $_GET['rota'];
    $usuarioCargo = $_SESSION['usuarioEspecialidade'];

    $rotasPermitidas = $permissoes[$usuarioCargo];

    if(in_array($rota, $rotasPermitidas)) {
        return true;
    } else {

        $rotaRedirecionada = $rotasPermitidas[0];

        $_SESSION['erros'] [] = "seu cargo $usuarioCargo não tem acesso a tela de $rota";
        header("Location: " . BASE_URL . "?rota=" . $rotaRedirecionada);
        exit();
    }
}


function permissoeMenu($rota){
    global $permissoes;
    $usuarioCargo = $_SESSION['usuarioEspecialidade'];
    $rotasPermitidas = $permissoes[$usuarioCargo];

    //retorna true se o usuario puder acesar a rota solicitada
    return in_array($rota, $rotasPermitidas); 
}



?>