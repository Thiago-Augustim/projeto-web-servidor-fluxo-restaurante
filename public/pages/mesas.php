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
                <div class="p-3 bg-secondary rounded me-4 ms-4 flex-grow-1 rounded-4">
                    <div class="row g-3">

                        <!-- Mesas -->
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="card text-center p-3 rounded card-mesa" style="background-color: var(--mesaLivreColor);">
                                <strong>Mesa 1</strong>
                                <span>Cadeiras: 5</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="card text-center p-3 rounded card-mesa" style="background-color: var(--mesaLivreColor);">
                                <strong>Mesa 1</strong>
                                <span>Cadeiras: 5</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="card text-center p-3 rounded card-mesa" style="background-color: var(--mesaLivreColor);">
                                <strong>Mesa 1</strong>
                                <span>Cadeiras: 5</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="card text-center p-3 rounded card-mesa" style="background-color: var(--mesaOcupadaColor);">
                                <strong>Mesa 1</strong>
                                <span>Cadeiras: 5</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="card text-center p-3 rounded card-mesa" style="background-color: var(--mesaReservadaColor);">
                                <strong>Mesa 1</strong>
                                <span>Cadeiras: 5</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="card text-center p-3 rounded card-mesa" style="background-color: var(--mesaReservadaColor);">
                                <strong>Mesa 1</strong>
                                <span>Cadeiras: 5</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="card text-center p-3 rounded card-mesa" style="background-color: var(--mesaOcupadaColor);">
                                <strong>Mesa 1</strong>
                                <span>Cadeiras: 5</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="card text-center p-3 rounded card-mesa" style="background-color: var(--mesaLivreColor);">
                                <strong>Mesa 1</strong>
                                <span>Cadeiras: 5</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="card text-center p-3 rounded card-mesa" style="background-color: var(--mesaLivreColor);">
                                <strong>Mesa 1</strong>
                                <span>Cadeiras: 5</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="card text-center p-3 rounded card-mesa" style="background-color: var(--mesaOcupadaColor);">
                                <strong>Mesa 1</strong>
                                <span>Cadeiras: 5</span>
                            </div>
                        </div>



                    </div>
                </div>




            </div>

        </div>

        <div class="col-3 bg-info-subtle flex-grow-1">Container lateral de Mesas</div>
    </div>


    <?php


    include '../partials/footer.php';
