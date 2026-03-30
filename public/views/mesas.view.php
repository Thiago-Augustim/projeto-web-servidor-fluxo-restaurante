<?php
$titulo = 'Mesas';
$paginaAtiva = 'mesas';
include '../partials/header.php';
?>

<body class="vh-100 d-flex flex-column">

    <?php include '../partials/nav.php'; ?>

    <div class="row gx-0 vh-100 d-flex">

        <div class="col-9 ">

            <div class="d-flex flex-column mb-3 ">

                <!-- Legenda e Botao Nova mesa -->
                <div class="d-flex justify-content-between align-items-center bg-cinzaClaro mx-4 my-3 rounded-4 flex-wrap gap-3 p-3">

                    <ul class="d-flex ps-4 mb-0 gap-5 align-items-center flex-wrap list-unstyled ps-2">
                        <li style="color: var(--mesaLivreColorLegenda)">● Mesa Livre</li>
                        <li style="color: var(--mesaOcupadaColorLegenda)">● Ocupado</li>
                        <li style="color: var(--mesaReservadaColorLegenda)">● Reservado</li>
                    </ul>

                    <button type="button" class="btn px-5 btn-hover" style="background-color: var(--buttonsColor); color: var(--branco)">
                        Nova Mesa
                    </button>

                </div>


                <!-- Container de Mesas -->
                <div class="p-3 rounded bg-cinzaClaro me-4 ms-4 flex-grow-1 rounded-4">
                    <div class="row g-3">

                        <!-- Faz um foreach em um array de mesas e preenche na tela -->
                        <?php require '../../src/data/mesas.php'; ?>


                        <?php foreach ($mesas as $mesa): ?>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                                <div class="card text-center p-3 rounded card-mesa"
                                    style="background-color: var(--mesa<?= ucfirst($mesa['status']) ?>Color);"
                                    data-mesa='<?= htmlspecialchars(json_encode($mesa), ENT_QUOTES) ?>'>

                                    <strong>Mesa <?= $mesa['numero'] ?></strong>
                                    <span>Cadeiras: <?= $mesa['cadeiras'] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Painel de Informações da Mesa -->
        <div class="col-3 flex-grow-1">
            <div class="d-flex flex-column mt-3">

                <div class="p-4 bg-cinzaClaro rounded-4 me-4 ms-4 mb-3 flex-grow-1">


                    <div class="d-flex justify-content-center align-items-center mb-3 pt-3 pb-3">
                        <h4 id="painel-numero">--</h4>
                    </div>

                    <h5>Quantidade de Cadeiras:</h5>
                    <p id="painel-cadeiras" class="border bg-light d-inline-block p-2 ps-3 pe-3 rounded-3"> <b> --</b></p>

                    <h5>Status:</h5>
                    <div class="dropdown">
                        <button class="btn btn-secondary bg-light text-secondary dropdown-toggle p-2 ps-4 pe-4 " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="painel-status">Livre</span>
                        </button>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item Livre" href="#">Livre</a></li>
                            <li><a class="dropdown-item Ocupado" href="#">Ocupado</a></li>
                            <li><a class="dropdown-item Reservado" href="#">Reservado</a></li>
                        </ul>
                    </div>

                </div>

                <div class="p-3 bg-cinzaClaro rounded-4 me-4 ms-4 flex-grow-1">
                    <h5>Pedidos da Mesa</h5>
                    <p>Selecione uma mesa para ver os pedidos</p>
                </div>

            </div>
        </div>
    </div>


    <?php


    include '../partials/footer.php';
