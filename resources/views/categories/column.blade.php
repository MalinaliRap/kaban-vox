<!-- Card com botão para adicionar tarefa -->
<div class="col-sm-12 col-md-3 col-lg-3">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>{{ $category->name }}</h4>
        </div>
        <div class="card-body">
            <div class="kanban-column">
                <div class="list-group">
                    <!-- Botão para abrir o modal -->
                    <button type="button" class="btn btn-primary addTaskButton" data-category-id="{{ $category->id }}">
                        Adicionar Tarefa
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('tasks.modal-create')

@section('scripts')
<script>
    $(document).ready(function() {
        // Abrir o modal e definir o ID da categoria ao clicar no botão "Adicionar Tarefa"
        $('.addTaskButton').on('click', function() {
            var categoryId = $(this).data('category-id'); // Obtém o ID da categoria
            $('#categoryId').val(categoryId); // Define o ID da categoria no campo oculto do formulário
            $('#addTaskModal').modal('show'); // Abre o modal
        });

        // Ação ao salvar a tarefa
        $('#saveTaskButton').on('click', function() {
            var formData = $('#taskForm').serialize(); // Serializa os dados do formulário
            var categoryId = $('#categoryId').val(); // Obtém o ID da categoria
            $.ajax({
                url: '{{ route('tasks.store', ['category' => 'categoryId']) }}'.replace('categoryId', categoryId), // Passa o categoryId para a URL
                method: 'POST',
                headers: {
                    authorization: 'Bearer ' + localStorage.getItem('token')
                },
                data: formData,
                success: function(response) {
                    alert('Tarefa salva com sucesso!');
                    $('#addTaskModal').modal('hide'); // Fecha o modal
                    // Aqui você pode atualizar a lista de tarefas ou fazer outra ação conforme necessário
                },
                error: function(xhr, status, error) {
                    alert('Erro ao salvar tarefa: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
