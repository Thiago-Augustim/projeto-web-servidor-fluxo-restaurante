<div class="modal fade" id="modalCardapio" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title">Cardápio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <div class="card h-100 shadow-sm">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Pizza Margherita</h6>
                  <small class="text-success fw-bold">R$ 45,00</small>
                </div>
                <div class="d-flex align-items-center">
                  <input type="number" id="qtd-pizza" value="1" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                  <button type="button" class="btn btn-sm btn-primary" onclick="adicionarAoPedido(1, 'Pizza Margherita', 45.00, 'qtd-pizza')">
                    Adicionar
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card h-100 shadow-sm">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Coca-Cola Lata</h6>
                  <small class="text-success fw-bold">R$ 6,00</small>
                </div>
                <div class="d-flex align-items-center">
                  <input type="number" id="qtd-coca" value="1" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                  <button type="button" class="btn btn-sm btn-primary" onclick="adicionarAoPedido(2, 'Coca-Cola Lata', 6.00, 'qtd-coca')">
                    Adicionar
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card h-100 shadow-sm">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Hamburger</h6>
                  <small class="text-success fw-bold">R$ 40,00</small>
                </div>
                <div class="d-flex align-items-center">
                  <input type="number" id="qtd-hamburger" value="1" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                  <button type="button" class="btn btn-sm btn-primary" onclick="adicionarAoPedido(3, 'Hamburger', 40.00, 'qtd-hamburger')">
                    Adicionar
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card h-100 shadow-sm">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Suco de Laranja</h6>
                  <small class="text-success fw-bold">R$ 20,00</small>
                </div>
                <div class="d-flex align-items-center">
                  <input type="number" id="qtd-suco" value="1" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                  <button type="button" class="btn btn-sm btn-primary" onclick="adicionarAoPedido(4, 'Suco de Laranja', 20.00, 'qtd-suco')">
                    Adicionar
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card h-100 shadow-sm">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Cachaça</h6>
                  <small class="text-success fw-bold">R$ 10,00</small>
                </div>
                <div class="d-flex align-items-center">
                  <input type="number" id="qtd-cachaca" value="1" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                  <button type="button" class="btn btn-sm btn-primary" onclick="adicionarAoPedido(5, 'Cachaca', 10.00, 'qtd-cachaca')">
                    Adicionar
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card h-100 shadow-sm">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Vinho Tinto</h6>
                  <small class="text-success fw-bold">R$ 50,00</small>
                </div>
                <div class="d-flex align-items-center">
                  <input type="number" id="qtd-vinho" value="1" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                  <button type="button" class="btn btn-sm btn-primary" onclick="adicionarAoPedido(6, 'Vinho Tinto', 50.00, 'qtd-vinho')">
                    Adicionar
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card h-100 shadow-sm">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Pudim</h6>
                  <small class="text-success fw-bold">R$ 20,00</small>
                </div>
                <div class="d-flex align-items-center">
                  <input type="number" id="qtd-pudim" value="1" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                  <button type="button" class="btn btn-sm btn-primary" onclick="adicionarAoPedido(7, 'Pudim', 20.00, 'qtd-pudim')">
                    Adicionar
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card h-100 shadow-sm">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">Bolo de Chocolate</h6>
                  <small class="text-success fw-bold">R$ 15,00</small>
                </div>
                <div class="d-flex align-items-center">
                  <input type="number" id="qtd-bolo" value="1" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                  <button type="button" class="btn btn-sm btn-primary" onclick="adicionarAoPedido(8, 'Bolo de Chocolate', 15.00, 'qtd-bolo')">
                    Adicionar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer bg-light d-block">
        <form id="form-pedido-final" action="<?= BASE_URL . '?rota=pedidos&acao=cadastrar' ?>" method="POST">
          <input type="hidden" id="input-mesa-pedido" name="id_mesa">

          <div id="resumo-pedido" class="mb-3">
            <h6>Itens Selecionados:</h6>
            <ul id="lista-visual-pedido" class="list-group list-group-flush mb-2">
              <li class="list-group-item text-muted">Nenhum item adicionado</li>
            </ul>
          </div>

          <div id="lista-inputs-hidden"></div>
          <div id="painel-valor-total"></div>

          <div class="d-flex justify-content-between align-items-center">
            <div id="display-numero-mesa" class="fw-bold">Mesa: --</div>
            <button type="submit" class="btn btn-success">Enviar Pedido ao Balcão</button>
          </div>
        </form>
      </div>
    </div>