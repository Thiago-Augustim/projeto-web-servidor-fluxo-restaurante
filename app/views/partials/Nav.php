<ul class="nav nav-underline d-flex justify-content-start p-2 bg-cinzaEscuro">
    <?php if (Auth::permiteMenu('mesas')): ?>
        <li class="nav-item ms-5">
            <a class="nav-link <?= $paginaAtiva === 'mesas' ? 'active' : '' ?>"
               href="<?= BASE_URL ?>mesas">Mesas</a>
        </li>
    <?php endif; ?>

    <?php if (Auth::permiteMenu('pedidos')): ?>
        <li class="nav-item ms-5">
            <a class="nav-link <?= $paginaAtiva === 'pedidos' ? 'active' : '' ?>"
               href="<?= BASE_URL ?>pedidos">Pedidos</a>
        </li>
    <?php endif; ?>

    <?php if (Auth::permiteMenu('comandas')): ?>
        <li class="nav-item ms-5">
            <a class="nav-link <?= $paginaAtiva === 'comandas' ? 'active' : '' ?>"
               href="<?= BASE_URL ?>comandas">Comandas</a>
        </li>
    <?php endif; ?>

    <?php if (Auth::permiteMenu('funcionarios')): ?>
        <li class="nav-item ms-5">
            <a class="nav-link <?= $paginaAtiva === 'funcionarios' ? 'active' : '' ?>"
               href="<?= BASE_URL ?>funcionarios">Funcionários</a>
        </li>
    <?php endif; ?>

    <li class="nav-item ms-auto me-3">
        <span class="text-white me-3"><?= $_SESSION['funcionarioLogado']['nome'] ?? 'Usuário' ?></span>
        <a href="<?= BASE_URL ?>logout" class="btn btn-danger px-4">Sair</a>
    </li>
</ul>