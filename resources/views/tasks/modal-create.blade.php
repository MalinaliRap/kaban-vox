
<!-- Modal para Adicionar Tarefa -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark">

      <!-- Cabeçalho do Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="addTaskModalLabel">Adicionar Nova Tarefa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Corpo do Modal -->
      <div class="modal-body">
        <form id="taskForm">
          @csrf
          <input type="hidden" id="categoryId" name="category_id"> <!-- Para armazenar o ID da categoria -->
          <div class="mb-3">
            <label for="taskName" class="form-label">Titulo da Tarefa</label>
            <input type="text" class="form-control" id="taskName" name="title" required>
          </div>
          <div class="mb-3">
            <label for="taskDescription" class="form-label">Descrição</label>
            <textarea class="form-control" id="taskDescription" name="description" rows="3"></textarea>
          </div>
        </form>
      </div>

      <!-- Rodapé do Modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="saveTaskButton">Salvar Tarefa</button>
      </div>
    </div>
  </div>
</div>
