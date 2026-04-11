<!-- Caixa de erro caso algum dado de uma nova mesa seja inválido -->
<div id="container-erros" class="toast-container position-fixed top-0 end-0 p-3">

    <?php if (!empty($_SESSION['erros'])): ?>
        <div class="toast show" role="alert" >
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">Erro</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                <?php foreach ($_SESSION['erros'] as $erro): ?>
                    <p class="mb-1"><?= $erro ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['erros']); ?>
<?php endif; ?>



