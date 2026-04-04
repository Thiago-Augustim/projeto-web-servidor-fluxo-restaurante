<ul class="nav nav-underline d-flex justify-content-start p-2 bg-cinzaEscuro ">
    <li class="nav-item ms-5">
        <a class="nav-link <?php echo $paginaAtiva === 'mesas' ? 'active' : '' ?>" href="#" onclick="location.replace('<?php echo BASE_URL; ?>rota=mesas');return false;">Mesas</a>
    </li>
    <li class="nav-item ms-5">
        <a class="nav-link <?php echo $paginaAtiva === 'pedidos' ? 'active' : '' ?>" href="#" onclick="location.replace('<?php echo BASE_URL; ?>rota=pedidos');return false;">Pedidos</a>
    </li>
    <li class="nav-item ms-5">
        <a class="nav-link <?php echo $paginaAtiva === 'comandas' ? 'active' : '' ?>" href="#" onclick="location.replace('<?php echo BASE_URL; ?>rota=comandas');return false   ;">Comandas</a>
    </li>
    <li class="nav-item ms-5">
        <a class="nav-link <?php echo $paginaAtiva === 'garcons' ? 'active' : '' ?>" href="#" onclick="location.replace('<?php echo BASE_URL; ?>rota=garcons');return false;">Garçons</a>
    </li>
    <li class="nav-item ms-5">
        <a class="nav-link <?php echo $paginaAtiva === 'relatorios' ? 'active' : '' ?>" href="#" onclick="location.replace('<?php echo BASE_URL; ?>rota=relatorios');return false;">Relatórios</a>
    </li>
</ul>