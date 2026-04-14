<?php
$titulo = 'Comandas';
$paginaAtiva = 'comandas';
include VIEWS . 'partials/header.php';
?>

<body class="vh-100 d-flex flex-column">

<?php include VIEWS . 'partials/nav.php'; ?>

<div class="row gx-0 vh-100 d-flex">

    <!-- LISTA DE COMANDAS -->
    <div class="col-9">

        <div class="d-flex flex-column mb-3">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center bg-cinzaClaro mx-4 my-3 rounded-4 flex-wrap gap-3 p-3">

                <h4 class="mb-0">Comandas Ativas</h4>

            </div>

            <!-- Container -->
            <div class="p-3 rounded bg-cinzaClaro me-4 ms-4 flex-grow-1 rounded-4">
                <div class="row g-4">

                    <?php if (empty($comandas)): ?>
                        <p class="text-muted">Nenhuma comanda ativa.</p>
                    <?php endif; ?>

                    <?php foreach ($comandas as $comanda): ?>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">

                            <div class="card p-3 rounded-4 card-comanda h-100"
                                data-comanda='<?= htmlspecialchars(json_encode($comanda), ENT_QUOTES) ?>'>

                                <strong class="mb-2">Mesa <?= $comanda['mesa'] ?></strong>

                                <ul class="list-unstyled small mb-2">
                                    <?php foreach ($comanda['itens'] as $item): ?>
                                        <li>
                                            <?= $item['quantidade'] ?>x <?= htmlspecialchars($item['nome']) ?>

                                            <?php if ($item['subtotal'] > 0): ?>
                                                <br>
                                                <span class="text-muted">
                                                    R$ <?= number_format($item['subtotal'], 2, ',', '.') ?>
                                                </span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                                <?php if ($comanda['total'] > 0): ?>
                                    <hr class="my-2">
                                    <strong>
                                        Total: R$ <?= number_format($comanda['total'], 2, ',', '.') ?>
                                    </strong>
                                <?php endif; ?>

                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <!-- COMANDAS FECHADAS -->
            <div class="p-3 rounded bg-cinzaClaro me-4 ms-4 mt-3 rounded-4">

                <h5 class="mb-3">Comandas Fechadas</h5>

                <div class="row g-4">

                    <?php if (empty($comandasFechadas)): ?>
                        <p class="text-muted">Nenhuma comanda fechada.</p>
                    <?php endif; ?>

                    <?php foreach ($comandasFechadas as $comanda): ?>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">

                            <div class="card p-3 rounded-4 h-100 bg-light">

                                <strong>Mesa <?= $comanda['mesa'] ?></strong>

                                <small class="text-muted">
                                    Total: R$ <?= number_format($comanda['total'], 2, ',', '.') ?>
                                </small>

                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>

            </div>
        </div>
    </div>

    

    <!-- PAINEL LATERAL -->
    <div class="col-3 flex-grow-1">

        <div class="d-flex flex-column mt-3">
            <!-- AÇÕES -->
            <div class="p-3 bg-cinzaClaro rounded-4 me-4 ms-4 flex-grow-1">

                <h5>Ações</h5>

                <div class="d-flex flex-column gap-2">

                    <button id="btn-fechar-comanda"
                        class="btn btn-danger">
                        Fechar Comanda
                    </button>
                </div>

            </div>

        </div>
    </div>

</div>





<?php
include VIEWS . 'components/Error.php';
include VIEWS . 'partials/footer.php';
?>