<?php

if (!isset($_SESSION['funcionarios'])) {
    $_SESSION['funcionarios'] = [
        ['id' => 1, 'nome' => 'João Silva', 'especialidade' => 'garcom'],
        ['id' => 2, 'nome' => 'Maria Oliveira', 'especialidade' => 'garcom'],
        ['id' => 3, 'nome' => 'Carlos Souza', 'especialidade' => 'cozinha'],
        ['id' => 4, 'nome' => 'Ana Costa', 'especialidade' => 'cozinha'],
    ];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'] ?? null;
    $especialidade = $_POST['especialidade'] ?? null;

    if ($nome && $especialidade) {

        $funcionarios = $_SESSION['funcionarios'];

        $novoId = count($funcionarios) + 1;

        $funcionarios[] = [
            'id' => $novoId,
            'nome' => $nome,
            'especialidade' => $especialidade
        ];

        $_SESSION['funcionarios'] = $funcionarios;
    }

    // evita duplicar ao dar F5
    header("Location: garcons.view.php");
    exit;
}

$funcionarios = $_SESSION['funcionarios'];