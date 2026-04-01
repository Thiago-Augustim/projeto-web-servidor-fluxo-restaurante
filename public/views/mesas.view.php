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

                    <button type="button" class="btn px-5 btn-hover" style="background-color: var(--buttonsColor); color: var(--branco)" data-bs-toggle="modal" data-bs-target="#modalMesa">
                        Nova Mesa
                    </button>

                </div>


                <!-- Container de Mesas -->
                <div class="p-3 rounded bg-cinzaClaro me-4 ms-4 flex-grow-1 rounded-4">
                    <div class="row g-3" id="listaMesas">

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
                            <span id="painel-status"></span>
                        </button>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item status-mesa" href="#">Livre</a></li>
                            <li><a class="dropdown-item status-mesa" href="#">Ocupada</a></li>
                            <li><a class="dropdown-item status-mesa" href="#">Reservada</a></li>
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

    <div class="modal fade" id="modalMesa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Nova Mesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Número da mesa</label>
                        <input type="number" id="numero" class="form-control" min="1" placeholder="Ex: 10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cadeiras</label>
                        <input type="number" id="cadeiras" class="form-control" min="1" placeholder="Ex: 4">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status inicial</label>
                        <select id="status" class="form-select">
                            <option value="livre">Livre</option>
                            <option value="ocupada">Ocupada</option>
                            <option value="reservada">Reservada</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" onclick="cadastrarMesa()">Cadastrar</button>
                </div>

            </div>
        </div>
    </div>

    <?php


    include '../partials/footer.php';
