<?php
$titulo = 'Login';

include VIEWS . 'partials/Header.php';
?>

<div class="min-vh-100 d-flex align-items-center justify-content-center bg-cinzaClaro">
    <div class="card p-4 shadow-sm" style="width: 100%; max-width: 400px;">

        <h4 class="text-center mb-4">Login</h4>

        <?php if (!empty($_SESSION['erros'])): ?>
            <div class="alert alert-danger">
                <?php foreach ($_SESSION['erros'] as $erro): ?>
                    <p class="mb-0"><?= $erro ?></p>
                <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['erros']); ?>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>?rota=login&amp;acao=entrar">

            <div class="mb-3">
                <label class="form-label">Usuário</label>
                <input type="text" name="usuario" class="form-control" 
                       placeholder="Seu usuario">
            </div>

            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control" 
                       placeholder="Sua senha">
            </div>

            <button type="submit" class="btn w-100" method="POST" action="<?= BASE_URL ?>?rota=login&amp;acao=entrar"
                    style="background-color: var(--buttonsColor); color: var(--branco)">
                Entrar
            </button>

        </form>
    </div>
</div>


<?php
require VIEWS . 'partials/Footer.php';
?>