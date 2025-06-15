<!-- Card com botão para adicionar tarefa -->
<div class="col-sm-12 col-md-4 col-lg-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $category->name }}</h4>
            <button class="btn btn-danger btn-sm delete-category-button" data-category-id="{{ $category->id }}">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="card-body bg-dark">
            <div class="kanban-column" data-category-id="{{ $category->id }}">
                <div class="list-group task-list">
                    @foreach ($category->tasks as $task)
                       @include('tasks.card', ['task' => $task])
                    @endforeach
                </div>
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
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Erro ao salvar tarefa: ' + xhr.responseJSON.message);
                }
            });
        });

        //task drag and drop
         $(".task-list").sortable({
            connectWith: ".task-list",
            items: ".kanban-task",
            placeholder: "ui-state-highlight",
            receive: function(event, ui) {
                var taskId = ui.item.data('task-id');
                var newCategoryId = $(this).closest('.kanban-column').data('category-id');
                console.log($(this).closest('.kanban-column').data('category-id'));
                $.ajax({
                    url: '{{ route('tasks.move', ':id') }}'.replace(':id', taskId),
                    type: 'POST',
                    headers: {
                        authorization: 'Bearer ' + localStorage.getItem('token')
                    },
                    data: {
                        category_id: newCategoryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Task moved successfully');
                    },
                    error: function() {
                        alert('Erro ao mover a tarefa!');
                    }
                });
            }
        }).disableSelection();

        //task delete
        $(document).on('click', '.delete-task-button', function() {
            var taskCard = $(this).closest('.kanban-task');
            var taskId = taskCard.data('task-id');

            if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
                $.ajax({
                    url: '{{ route('tasks.destroy', ':id') }}'.replace(':id', taskId),
                    type: 'DELETE',
                    headers: {
                        authorization: 'Bearer ' + localStorage.getItem('token')
                    },
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        taskCard.remove(); // Remove o card da tela
                        console.log('Tarefa excluída com sucesso');
                    },
                    error: function() {
                        alert('Erro ao excluir a tarefa.');
                    }
                });
            }
        });

        //category delete
        $(document).on('click', '.delete-category-button', function() {
            var categoryId = $(this).data('category-id');
            if (confirm('Tem certeza que deseja excluir esta categoria?')) {
                $.ajax({
                    url: '{{ route('categories.destroy', ':id') }}'.replace(':id', categoryId),
                    type: 'DELETE',
                    headers: {
                        authorization: 'Bearer ' + localStorage.getItem('token')
                    },
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('.kanban-column[data-category-id="' + categoryId + '"]').remove(); // Remove o card da tela
                        console.log('Categoria excluida com sucesso');
                    },
                    error: function(error) {
                        alert(error.responseJSON.message);
                    }
                });
            }
        })
    });
</script>
@endsection
