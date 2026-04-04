<?php
// TODO: substituir pelo banco depois
$usuarios = [
    ['usuario' => 'admin',  'senha' => '1234', 'tipo' => 'admin'],
    ['usuario' => 'joao',   'senha' => '1234', 'tipo' => 'garcom'],
    ['usuario' => 'carlos', 'senha' => '1234', 'tipo' => 'cozinha'],
];

//teste push

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($usuarios as $u) {
        if ($_POST['usuario'] === $u['usuario'] && $_POST['senha'] === $u['senha']) {
            setcookie('tipo', $u['tipo']);

            // redireciona para a primeira página permitida
            $primeirasPaginas = [
                'admin'  => 'mesas.view.php',
                'garcom' => 'pedidos.view.php',
                'cozinha'=> 'comandas.view.php',
            ];

            header('Location: views/' . $primeirasPaginas[$u['tipo']]);
            exit;
        }
    }
    $erro = 'Usuário ou senha incorretos.';
}
?>

<?php $titulo = 'Login'; include 'partials/header.php'; ?>

<body class="vh-100 d-flex align-items-center justify-content-center bg-cinzaClaro">

    <div class="card p-4 shadow" style="width: 360px;">

        <h4 class="text-center mb-4">Fluxo Restaurante</h4>

        <?php if ($erro): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Usuário</label>
                <input type="text" name="usuario" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn w-100 text-white btn-hover"
                style="background-color: var(--buttonsColor);">
                Entrar
            </button>
        </form>

    </div>
    
<?php include 'partials/footer.php'; ?>