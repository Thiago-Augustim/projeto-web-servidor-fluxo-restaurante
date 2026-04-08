<?php
$titulo = 'Mesas';
$paginaAtiva = 'mesas';
include VIEWS . 'partials/header.php';
?>

<body class="vh-100 d-flex flex-column">

    <?php include VIEWS . 'partials/nav.php'; ?>

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

                        <!-- Caixa de erro caso algum dado de uma nova mesa seja inválido -->
                        <?php if (!empty($_SESSION['erros'])): ?>
                            <div class="toast-container position-fixed top-0 end-0 p-3">
                                <div class="toast show" role="alert">
                                    <div class="toast-header bg-danger text-white">
                                        <strong class="me-auto">Erro</strong>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                                    </div>
                                    <div class="toast-body">
                                        <?php foreach ($_SESSION['erros'] as $erro): ?>
                                            <p class="mb-1"><?= $erro ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php unset($_SESSION['erros']); ?>
                        <?php endif; ?>

                        <!-- Faz um foreach em um array de mesas e preenche na tela -->
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

                        <!-- Caixa de erros para alterar o status da mesa -->
                        <?php if (!empty($_SESSION['erros'])): ?>
                            <div class="toast-container position-fixed top-0 end-0 p-3">
                                <div class="toast show" role="alert">
                                    <div class="toast-header bg-danger text-white">
                                        <strong class="me-auto">Erro</strong>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                                    </div>
                                    <div class="toast-body">
                                        <?php foreach ($_SESSION['erros'] as $erro): ?>
                                            <p class="mb-1"><?= $erro ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php unset($_SESSION['erros']); ?>
                        <?php endif; ?>


                        <form method="POST" action="<?= BASE_URL ?>?rota=mesas&amp;acao=alterarStatusMesa">

                            <input type="hidden" name="id" class="input-mesa-id" value="">

                            <select name="status" class="form-select" id="painel-status">
                                <option value="livre">Livre</option>
                                <option value="ocupada">Ocupada</option>
                                <option value="reservada">Reservada</option>
                            </select>

                            <div class="d-flex justify-content-between mt-2">
                                <button type="submit" class="btn mt-2"
                                    style="background-color: var(--buttonsColor); color: var(--branco)">
                                    Alterar
                                </button>

                                <button type="submit"
                                        formaction="<?= BASE_URL ?>?rota=mesas&amp;acao=excluirMesa"
                                        class="btn mt-2 btn-danger">
                                    Excluir Mesa
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="p-3 bg-cinzaClaro rounded-4 me-4 ms-4 flex-grow-1">
                    <h5>Pedidos da Mesa</h5>
                    <div id="lista-pedidos">
                        <p class="text-muted">Selecione uma mesa para ver os pedidos</p>
                    </div>
                    <hr>
                    <p><strong>Total: R$ <span id="total-pedidos">0,00</span></strong></p>

                    <button class="btn w-100 btn-hover mt-2"
                        style="background-color: var(--buttonsColor); color: var(--branco);"
                        data-bs-toggle="modal" data-bs-target="#modalCardapio">
                        Cardápio
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal de Cadastro de Mesa -->
    <form class="modal fade" id="modalMesa" tabindex="-1" method="POST" action="<?php echo BASE_URL . '?rota=mesas&acao=cadastrar' ?>">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Nova Mesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Número da mesa</label>
                        <input type="number" name="numero" id="numero" class="form-control" min="1" placeholder="Ex: 10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cadeiras</label>
                        <input type="number" name="cadeiras" id="cadeiras" class="form-control" min="1" placeholder="Ex: 4">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status inicial</label>
                        <select name="status" id="status" class="form-select">
                            <option value="livre">Livre</option>
                            <option value="ocupada">Ocupada</option>
                            <option value="reservada">Reservada</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Cadastrar</button>
                </div>

            </div>
        </div>
    </form>

    <!-- Caixa de erros para alterar o status da mesa -->
                        <?php if (!empty($_SESSION['errosExclusao'])): ?>
                            <div class="toast-container position-fixed top-0 end-0 p-3">
                                <div class="toast show" role="alert">
                                    <div class="toast-header bg-danger text-white">
                                        <strong class="me-auto">Erro</strong>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                                    </div>
                                    <div class="toast-body">
                                        <?php foreach ($_SESSION['errosExclusao'] as $erroExclusao): ?>
                                            <p class="mb-1"><?= $erroExclusao ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php unset($_SESSION['errosExclusao']); ?>
                        <?php endif; ?>
    <!-- Modal Cardápio -->
<div class="modal fade" id="modalCardapio" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="<?= BASE_URL ?>?rota=pedidos&acao=adicionar">
                <input type="hidden" name="mesa_id" class="input-mesa-id" value="">
                <input type="hidden" name="item"    value="Cardápio">
                <input type="hidden" name="preco"   value="10.00">

                <div class="modal-header">
                    <h5 class="modal-title">Cardápio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3">
                        <span>Cardápio</span>
                        <strong>R$ 10,00</strong>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar Pedido</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    const todosPedidos = <?= json_encode(array_values($_SESSION['pedidos'] ?? [])) ?>;
</script>

    <?php


    include VIEWS . 'partials/footer.php';
