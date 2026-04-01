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

                        <?php require '../../src/data/mesas.php'; ?>
                        <?php require '../../src/data/pedidos.php'; ?>

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
                        <button class="btn btn-secondary bg-light text-secondary dropdown-toggle p-2 ps-4 pe-4 " type="button" data-bs-toggle="dropdown">
                            <span id="painel-status"></span>
                        </button>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item status-mesa" href="#">Livre</a></li>
                            <li><a class="dropdown-item status-mesa" href="#">Ocupada</a></li>
                            <li><a class="dropdown-item status-mesa" href="#">Reservada</a></li>
                        </ul>
                    </div>

                    <!-- ✅ BOTÃO ADICIONADO -->
                    <button id="btn-abrir-pedido"
                        class="btn mb-3 w-100 btn-hover mt-3        "
                        style="background-color: var(--buttonsColor); color: var(--branco);">
                        Novo Pedido
                    </button>

                </div>

                <!-- ✅ div com id para o JS escrever -->
                <div class="p-3 bg-cinzaClaro rounded-4 me-4 ms-4 flex-grow-1">
                    <h5>Pedidos da Mesa</h5>
                    <div id="painel-pedidos">
                        <p>Selecione uma mesa para ver os pedidos</p>
                    </div>
                </div>

            </div>
        </div>
    </div>


                    <?php
                    $produtos = [
                        ['id'=>1,  'nome'=>'X-Burguer',         'tipo'=>'comida', 'preco'=>28.90],
                        ['id'=>2,  'nome'=>'X-Salada',           'tipo'=>'comida', 'preco'=>25.90],
                        ['id'=>3,  'nome'=>'Frango Grelhado',    'tipo'=>'comida', 'preco'=>34.00],
                        ['id'=>4,  'nome'=>'Batata Frita',       'tipo'=>'comida', 'preco'=>16.00],
                        ['id'=>5,  'nome'=>'Pizza Calabresa',    'tipo'=>'comida', 'preco'=>52.00],
                        ['id'=>6,  'nome'=>'Prato Feito',        'tipo'=>'comida', 'preco'=>22.00],
                        ['id'=>7,  'nome'=>'Risoto de Cogumelo', 'tipo'=>'comida', 'preco'=>45.00],
                        ['id'=>8,  'nome'=>'Coca-Cola 350ml',    'tipo'=>'bebida', 'preco'=> 7.00],
                        ['id'=>9,  'nome'=>'Suco de Laranja',    'tipo'=>'bebida', 'preco'=>10.00],
                        ['id'=>10, 'nome'=>'Cerveja Long Neck',  'tipo'=>'bebida', 'preco'=>12.00],
                        ['id'=>11, 'nome'=>'Água Mineral',       'tipo'=>'bebida', 'preco'=> 5.00],
                        ['id'=>12, 'nome'=>'Suco de Uva',        'tipo'=>'bebida', 'preco'=>10.00],
                    ];
                    ?>

                    <!-- Filtros -->
                    <div class="d-flex gap-2 mb-3">
                        <button class="btn btn-sm btn-secondary btn-filtro-cat ativo" data-cat="todos">Todos</button>
                        <button class="btn btn-sm btn-outline-secondary btn-filtro-cat" data-cat="comida">🍔 Comida</button>
                        <button class="btn btn-sm btn-outline-secondary btn-filtro-cat" data-cat="bebida">🥤 Bebida</button>
                    </div>

                    <!-- Produtos -->
                    <div class="row g-2" id="grid-produtos">
                        <?php foreach ($produtos as $prod): ?>
                            <div class="col-4 produto-item" data-cat="<?= $prod['tipo'] ?>">
                                <div class="border rounded-3 p-2 d-flex justify-content-between align-items-center bg-light"
                                     data-id="<?= $prod['id'] ?>"
                                     data-nome="<?= htmlspecialchars($prod['nome']) ?>"
                                     data-tipo="<?= $prod['tipo'] ?>"
                                     data-preco="<?= $prod['preco'] ?>">
                                    <div>
                                        <div class="fw-semibold small"><?= $prod['nome'] ?></div>
                                        <div class="text-muted" style="font-size:.75rem">
                                            R$ <?= number_format($prod['preco'], 2, ',', '.') ?>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <button class="btn btn-sm btn-outline-secondary rounded-circle btn-menos px-2 py-0"
                                                data-id="<?= $prod['id'] ?>">−</button>
                                        <span id="qty-<?= $prod['id'] ?>" class="fw-bold small" style="min-width:20px;text-align:center">0</span>
                                        <button class="btn btn-sm btn-outline-secondary rounded-circle btn-mais px-2 py-0"
                                                data-id="<?= $prod['id'] ?>">+</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Resumo -->
                    <div class="mt-3 p-3 rounded-3 bg-cinzaClaro">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Itens selecionados:</span>
                            <span id="resumo-qtd" class="small">0 item(ns)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>Total:</strong>
                            <span id="resumo-total" class="fs-5 fw-bold"
                                  style="color: var(--buttonsColor)">R$ 0,00</span>
                        </div>
                    </div>

                    <!-- Ações -->
                    <div class="d-flex justify-content-end mt-3 gap-2">
                        <button class="btn btn-outline-secondary rounded-3 px-4"
                                data-bs-dismiss="modal">Cancelar</button>
                        <button id="btn-confirmar-pedido"
                                class="btn btn-hover px-5 disabled"
                                style="background-color: var(--buttonsColor); color: var(--branco)">
                            ✔ Confirmar Pedido
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Variável gerada pelo PHP — precisa ficar aqui -->
<script>
    const pedidos = <?= json_encode(array_values($pedidos)) ?>;
</script>
    

<?php
include '../partials/footer.php';