<!-- Toast de sucesso -->
<div id="container-sucesso" class="toast-container position-fixed top-0 end-0 p-3">
<?php if (!empty($_SESSION['sucesso'])): ?>
        <div class="toast show" role="alert">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Sucesso</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                <?= $_SESSION['sucesso'] ?>
            </div>
        </div>
        <?php unset($_SESSION['sucesso']); ?>
    <?php endif; ?>
</div>
