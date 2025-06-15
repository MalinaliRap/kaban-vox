@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Kanban - {{ $board->name }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>Descricao: {{ $board->description }}</h5>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-10">

                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4>Criar Nova Categoria:</h4>
                    </div>
                    <div class="card-body">

                        {{-- Formulário para criar categoria --}}
                        <form id="categoryForm">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome da Categoria:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ex: todo" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Criar Categoria</button>
                        </form>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="card-header bg-primary text-white p-3 mb-5">
                        <h4>Categorias</h4>
                    </div>

                    <div class="row kanban-categories d-flex flex-wrap gap-4">
                        @foreach ($board->categories as $category)
                            @include('categories.column', ['category' => $category])
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
            $('#categoryForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('categories.store', $board->id) }}',
                    method: 'POST',
                    headers: {
                        authorization: 'Bearer ' + localStorage.getItem('token')
                    },
                    data: formData,
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('Erro: ' + (xhr.responseJSON.message || 'Erro desconhecido'));
                    }
                });
            });
        });
    </script>
@endsection

