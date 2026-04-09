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
                
                <form action="<?=  BASE_URL . '?rota=pedidos&acao=cadastrar'?>" method="POST" class="d-flex align-items-center">
                  <input type="hidden" name="produto" value="PizzaMargherita">
                  <input type="hidden" name="preco" value="45.00">
                  <input type="hidden" name="id_mesa" class="input-mesa-selecionada" value="">
                  <input type="number" name="quantidade" value="1" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                  <button type="submit" class="btn btn-sm btn-primary">Adicionar</button>
                </form>
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
                
                <form action="<?= BASE_URL . '?rota=pedidos&acao=cadastrar' ?>" method="POST" class="d-flex align-items-center">
                  <input type="hidden" name="produto" value="CocaColaLata">
                  <input type="hidden" name="preco" value="6.00">
                  <input type="hidden" name="id_mesa" class="input-mesa-selecionada" value="">
                  <input type="number" name="quantidade" value="1" min="1" class="form-control form-control-sm me-2" style="width: 60px;">
                  <button type="submit" class="btn btn-sm btn-primary">Adicionar</button>
                </form>
              </div>
            </div>
          </div>

        </div>
    </div>
  </div>
</div>

