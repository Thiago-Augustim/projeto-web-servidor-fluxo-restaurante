<?php
$titulo      = 'Pedidos';
$paginaAtiva = 'pedidos';
include VIEWS . 'partials/header.php';

$statusLabels = [
    'aguardando' => 'Aguardando',
    'cancelado'  => 'Cancelado',
    'em_preparo' => 'Em preparo',
    'concluido'  => 'Concluído',
];



$statusColors = [
    'aguardando' => '#b0b0b0',
    'cancelado'  => '#6c6c6c',
    'em_preparo' => '#c9a227',
    'concluido'  => '#4caf50',
];
?>

<body class="vh-100 d-flex flex-column">

    <?php include VIEWS . 'partials/nav.php'; ?>

    <div class="row gx-0 flex-grow-1 d-flex" style="overflow:hidden;">

        <!-- LISTA DE PEDIDOS -->
        <div class="col-9 d-flex flex-column" style="overflow-y: auto;">
            <div class="d-flex flex-column m-4 gap-3">

                <!-- Filtros -->
                <div class="d-flex gap-2 flex-wrap p-3 bg-cinzaClaro rounded-4">
                    <?php foreach ($statusLabels as $key => $label): ?>
                        <button class="btn btn-filtro px-4 rounded-pill"
                            data-status="<?= $key ?>"
                            style="background-color: <?= $statusColors[$key] ?>; color: white;">
                            <?= $label ?>
                        </button>
                    <?php endforeach; ?>
                    <button class="btn btn-filtro px-4 rounded-pill"
                        data-status="todos"
                        style="background-color: var(--cinzaEscuro); color: white;">
                        Todos
                    </button>
                </div>

                <!-- Cards de Pedidos -->
                <div class="d-flex flex-column gap-3" id="listaPedidos">

                    <?php if (empty($pedidos)): ?>
                        <p class="text-muted ps-2">Nenhum pedido registrado ainda.</p>
                    <?php endif; ?>

                    <?php foreach ($pedidos as $pedido) : ?>     

                    <div class="card p-3 rounded-4 card-pedido"
                        data-status="<?= $pedido['status'] ?>"
                        data-pedido='<?= htmlspecialchars(json_encode($pedido), ENT_QUOTES) ?>'
                        style="cursor:pointer;">

                        <div class="d-flex align-items-center gap-4">

                            <div style="min-width:100px;">
                                <small class="text-muted">Nº Pedido:</small>
                                <h4 class="mb-0">#<?= $pedido['id'] ?></h4>
                            </div>

                            <div style="min-width:80px;">
                                <small class="text-muted">Mesa:</small>
                                <h4 class="mb-0"><?= $pedido['numeroMesa'] ?></h4>
                            </div>

                            <div class="flex-grow-1">
                                <small class="text-muted">Itens:</small>
                                <?php foreach ($pedido['itens'] as $item): ?>
                                    <div><?= $item['quantidade'] ?>x <?= htmlspecialchars($item['nome']) ?></div>
                                <?php endforeach; ?>
                            </div>

                            <div>
                                <span class="badge rounded-pill px-3 py-2"
                                    style="background-color: <?= $statusColors[$pedido['status']] ?>; font-size: 0.85rem;">
                                    <?= $statusLabels[$pedido['status']] ?>
                                </span>
                            </div>

                        </div>
                    </div>
                         <?php
                             endforeach; ?>
                     

                </div>
            </div>
        </div>

        <!-- PAINEL DIREITO FIXO -->
        <div class="col-3 d-flex flex-column" style="overflow-y:auto; border-left: 1px solid #ccc;">
            <div class="d-flex flex-column m-3 gap-3">

                <!-- Título do pedido -->
                <div class="bg-cinzaClaro rounded-4 p-4 text-center">
                    <h3 class="fw-bold mb-0" id="painel-titulo">PEDIDO<br>--</h3>
                </div>

                <!-- Mesa e status -->
                <div class="bg-cinzaClaro rounded-4 p-4">
                    <h6>Mesa:</h6>
                    <div class="border bg-light d-inline-block p-2 px-3 rounded-3 mb-3">
                        <b id="painel-mesa">--</b>
                    </div>

                    <h6>Mudar Status:</h6>
                    <form method="POST" action="<?= BASE_URL ?>?rota=pedidos&acao=alterarStatus">
                        <input type="hidden" name="id" id="input-pedido-id" value="">
                        <div class="d-grid gap-2">
                            <div class="row g-2">
                                <?php foreach ($statusLabels as $key => $label): ?>
                                    <div class="col-6">
                                        <button type="submit" name="status" value="<?= $key ?>"
                                            class="btn w-100 rounded-3"
                                            style="background-color: <?= $statusColors[$key] ?>; color: white; font-size:0.8rem;">
                                            <?= $label ?>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Detalhes do pedido -->
                <div class="bg-cinzaClaro rounded-4 p-4">
                    <h6 class="fw-bold mb-3">Detalhes do pedido</h6>
                    <div id="painel-itens">
                        <p class="text-muted">Selecione um pedido</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <?= include VIEWS . 'components/Error.php' ?>
    <?php include VIEWS . 'partials/footer.php'; ?>