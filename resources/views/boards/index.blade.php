@extends('layouts.app')

@section('content')
 <div class="container my-5">

    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4>Criar Novo Quadro</h4>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Formulário para criar quadro --}}
                    <form id="boardForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Quadro:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Projeto Kanban" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição:</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Ex: Descrição do quadro" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Criar Quadro</button>
                    </form>
                </div>
            </div>

            <div class="mt-5">
                {{-- Exemplo de Quadros (Cards) --}}
                <div class="card-header bg-primary text-white p-3 mb-5">
                    <h4>Quadros</h4>
                </div>

                <div class="kanban-board d-flex flex-wrap gap-4">
                    @foreach ($boards as $board)
                        @include('boards.card', ['board' => $board])
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        // Ao clicar no botão de criar quadro
        $('#boardForm').on('submit', function(e) {
            e.preventDefault(); // Evita o envio padrão do formulário

            var formData = $(this).serialize(); // Serializa os dados do formulário

            $.ajax({
                url: '{{ route('boards.store') }}', // URL para a rota de criação de quadro
                method: 'POST',
                headers: {
                    authorization: 'Bearer ' + localStorage.getItem('token')
                },
                data: formData,
                success: function(response) {
                    // Se a criação do quadro for bem-sucedida, recarrega a página
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    // Se ocorrer erro, exibe a mensagem de erro no console
                    alert('Erro: ' + (xhr.responseJSON.message || 'Erro desconhecido'));
                }
            })
        });
         // Ao clicar no botão de excluir quadro
        $('.deleteBoardButton').on('click', function() {
            var boardId = $(this).data('board-id'); // Obtém o ID do board

            $.ajax({
                url: '{{ route('boards.destroy', ':id') }}'.replace(':id', boardId), // Rota de exclusão
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token') // Token de autenticação
                },
                success: function(response) {
                    // Se a exclusão for bem-sucedida, remove o card do DOM
                    alert('Board excluído com sucesso!');
                    $('.kanban-card[data-board-id="' + boardId + '"]').remove();

                },
                error: function(xhr, status, error) {
                    // Se houver erro, exibe a mensagem de erro
                    alert('Erro: ' + (xhr.responseJSON.message || 'Erro desconhecido'));
                }
            });
        });
    });
</script>
@endsection

