<?php
$titulo = 'Comandas';
$paginaAtiva = 'comandas';
include VIEWS . 'partials/header.php';
?>

<body class="vh-100 d-flex flex-column">

<?php include VIEWS . 'partials/nav.php'; ?>

<div class="container mt-4">

    <h2 class="mb-4">Comandas</h2>

    <?php if (empty($comandas)): ?>
        <p class="text-muted">Nenhuma comanda ativa.</p>
    <?php endif; ?>

    <div class="row">

        <?php foreach ($comandas as $comanda): ?>
            <div class="col-md-4 mb-4">

                <div class="card p-3 rounded-4">

                    <h4>Mesa <?= $comanda['mesa'] ?></h4>

                    <ul class="list-unstyled">
                        <?php foreach ($comanda['itens'] as $item): ?>
                            <li>
                                <?= $item['quantidade'] ?>x <?= htmlspecialchars($item['nome']) ?>

                                <?php if ($item['subtotal'] > 0): ?>
                                    - R$ <?= number_format($item['subtotal'], 2, ',', '.') ?>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <?php if ($comanda['total'] > 0): ?>
                        <hr>
                        <strong>Total: R$ <?= number_format($comanda['total'], 2, ',', '.') ?></strong>
                    <?php endif; ?>

                </div>

            </div>
        <?php endforeach; ?>

    </div>

</div>

<?php include VIEWS . 'components/Error.php'; ?>
<?php include VIEWS . 'partials/footer.php'; ?>