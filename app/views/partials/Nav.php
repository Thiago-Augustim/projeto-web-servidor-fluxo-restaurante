<ul class="nav nav-underline d-flex justify-content-start p-2 bg-cinzaEscuro">
    <?php if (Auth::permiteMenu('mesas')): ?>
        <li class="nav-item ms-5">
            <a class="nav-link <?= $paginaAtiva === 'mesas' ? 'active' : '' ?>"
               href="#" onclick="location.replace('<?= BASE_URL ?>?rota=mesas');return false;">Mesas</a>
        </li>
    <?php endif; ?>

    <?php if (Auth::permiteMenu('pedidos')): ?>
        <li class="nav-item ms-5">
            <a class="nav-link <?= $paginaAtiva === 'pedidos' ? 'active' : '' ?>"
               href="#" onclick="location.replace('<?= BASE_URL ?>?rota=pedidos');return false;">Pedidos</a>
        </li>
    <?php endif; ?>

    <?php if (Auth::permiteMenu('comandas')): ?>
        <li class="nav-item ms-5">
            <a class="nav-link <?= $paginaAtiva === 'comandas' ? 'active' : '' ?>"
               href="#" onclick="location.replace('<?= BASE_URL ?>?rota=comandas');return false;">Comandas</a>
        </li>
    <?php endif; ?>

    <?php if (Auth::permiteMenu('funcionarios')): ?>
        <li class="nav-item ms-5">
            <a class="nav-link <?= $paginaAtiva === 'funcionarios' ? 'active' : '' ?>"
               href="#" onclick="location.replace('<?= BASE_URL ?>?rota=funcionarios');return false;">Funcionários</a>
        </li>
    <?php endif; ?>

    <li class="nav-item ms-auto me-3">
        <span class="text-white me-3"><?= $_SESSION['funcionarioLogado']['nome'] ?? 'Usuário' ?></span>
        <a href="<?= BASE_URL ?>?rota=logout" class="btn btn-danger px-4">Sair</a>
    </li>
</ul>
