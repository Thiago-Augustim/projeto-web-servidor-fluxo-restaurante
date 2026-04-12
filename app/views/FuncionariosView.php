<?php
$titulo = 'Funcionários';
$paginaAtiva = 'funcionarios';
include VIEWS . 'partials/header.php';
?>

<body class="vh-100 d-flex flex-column">

<?php include VIEWS . 'partials/nav.php'; ?>

<div class="row gx-0 vh-100 d-flex">

    <!-- LISTA -->
    <div class="col-9">
        <div class="d-flex flex-column mb-3">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center bg-cinzaClaro mx-4 my-3 rounded-4 flex-wrap gap-3 p-3">

                <h5 class="mb-0">Equipe</h5>

                <button class="btn px-5 btn-hover" data-bs-toggle="modal" data-bs-target="#modalFuncionario"
                    style="background-color: var(--buttonsColor); color: var(--branco)"> 
                    Novo Funcionário
                </button>

            </div>

            <!-- Container -->
            <div class="p-3 rounded bg-cinzaClaro me-4 ms-4 flex-grow-1 rounded-4">
                <div class="row g-3">

                    <?php foreach ($funcionarios as $funcionario): ?>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                            <div class="card text-center p-3 rounded card-funcionario"
                                data-funcionario='<?= htmlspecialchars(json_encode($funcionario), ENT_QUOTES) ?>'
                                style="cursor:pointer;">

                                <strong><?= $funcionario['nome'] ?></strong>
                                <span><?= ucfirst($funcionario['especialidade']) ?></span>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

        </div>
    </div>

    <!-- PAINEL DIREITA -->
    <div class="col-3 flex-grow-1">
        <div class="d-flex flex-column mt-3">

            <div class="p-4 bg-cinzaClaro rounded-4 me-4 ms-4 mb-3 flex-grow-1">

                <div class="d-flex justify-content-center align-items-center mb-3 pt-3 pb-3">
                    <h4 id="painel-nome">--</h4>
                </div>

                <h5>ID:</h5>
                <p id="painel-id" class="border bg-light d-inline-block p-2 ps-3 pe-3 rounded-3">
                    <b>--</b>
                </p>

                <h5>Função:</h5>
                <p id="painel-especialidade" class="border bg-light d-inline-block p-2 ps-3 pe-3 rounded-3">
                    <b>--</b>
                </p>
                <form method="POST" action="<?= BASE_URL ?>?rota=funcionarios&acao=excluir" id="form-excluir">
                    <input type="hidden" name="id" id="input-excluir-id">
    
                    <button type="submit" class="btn btn-danger w-100 mt-3">
                     Excluir Funcionário
                    </button>
                </form>

            </div>

            <div class="p-3 bg-cinzaClaro rounded-4 me-4 ms-4 flex-grow-1">
                <h5>Atividade</h5>
                <p>Selecione um funcionário para ver detalhes</p>
            </div>

        </div>
    </div>

</div>

<!-- Tela para subir e add novo funcionario -->
<div class="modal fade" id="modalFuncionario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="<?= BASE_URL ?>?rota=funcionarios&acao=cadastrar">
                <div class="modal-header">
                    <h5>Novo Funcionário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" id="nome" name="nome" class="form-control mb-3" placeholder="Nome completo" required>
                    <input type="text" id="usuario" name="usuario" class="form-control mb-3" placeholder="Usuário" readonly>
                    <input type="password" name="senha" class="form-control mb-3" placeholder="Senha" required>
                    <select name="especialidade" class="form-control">
                        <option value="garcom">Garçom</option>
                        <option value="cozinha">Cozinha</option>
                        <option value="cozinha">Gerencia</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include VIEWS . 'partials/footer.php'; ?>