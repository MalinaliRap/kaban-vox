<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Novo Quadro - Kanban</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .kanban-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="bg-dark">

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Kanban</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <button id="logoutButton" class="btn btn-danger">Logout</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

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

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulário para criar quadro --}}
                    <form method="POST" action="{{ route('boards.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Quadro:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Projeto Kanban" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Criar Quadro</button>
                    </form>
                </div>
            </div>

            <div class="mt-5">
                {{-- Exemplo de Quadros (Cards) --}}
                <h4>Quadros de Exemplo</h4>

                <div class="kanban-board d-flex flex-wrap gap-4">

                    {{-- Quadro 1 --}}
                    <div class="kanban-card col-3">
                        <h5>Quadro 1</h5>
                        <div class="list-group">
                            <div class="list-group-item">
                                Tarefa 1: Criar Layout
                            </div>
                            <div class="list-group-item">
                                Tarefa 2: Definir Backend
                            </div>
                        </div>
                    </div>

                    {{-- Quadro 2 --}}
                    <div class="kanban-card col-3">
                        <h5>Quadro 2</h5>
                        <div class="list-group">
                            <div class="list-group-item">
                                Tarefa 3: Desenvolver API
                            </div>
                            <div class="list-group-item">
                                Tarefa 4: Conectar ao Banco
                            </div>
                        </div>
                    </div>

                    {{-- Quadro 3 --}}
                    <div class="kanban-card col-3">
                        <h5>Quadro 3</h5>
                        <div class="list-group">
                            <div class="list-group-item">
                                Tarefa 5: Testar Funcionalidade
                            </div>
                            <div class="list-group-item">
                                Tarefa 6: Implementar Auth
                            </div>
                        </div>
                    </div>

                    {{-- Quadro 4 --}}
                    <div class="kanban-card col-3">
                        <h5>Quadro 4</h5>
                        <div class="list-group">
                            <div class="list-group-item">
                                Tarefa 7: Deploy Inicial
                            </div>
                            <div class="list-group-item">
                                Tarefa 8: Criar Documentação
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> {{-- jQuery --}}
<script>
     function logout() {
        var token = localStorage.getItem('token'); // Ou de onde você armazena o token

        if (!token) {
            alert('Token não encontrado.');
            return;
        }

        $.ajax({
            url: '{{ route('logout') }}', // Rota de logout
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token // Envia o token no cabeçalho
            },
            data: {
                _token: '{{ csrf_token() }}' // CSRF token para garantir a segurança
            },
            success: function(response) {
                alert(response.message); // Exibe a resposta de sucesso
                window.location.href = "/"; // Redireciona para a página inicial
            },
            error: function(xhr, status, error) {
                alert('Erro ao realizar logout'); // Exibe a mensagem de erro
            }
        });
    }

    $(document).ready(function() {
        $('#logoutButton').on('click', function() {
            logout();
        });
    });
</script>

</body>
</html>
