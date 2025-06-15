<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Kanban') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-dark text-white">

    <!-- Barra de navegação para usuários logados -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Kanban</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <!-- Adicionando o ID ao botão de logout -->
                        <button id="logoutButton" class="btn btn-danger">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo da página -->
    <div class="container mt-5">
        @yield('content')  <!-- Aqui o conteúdo da página do usuário logado será injetado -->
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')  <!-- Scripts adicionais da página -->

    <script>
        // Função de logout via AJAX
        function logout() {
            $.ajax({
                url: '{{ url("api/logout") }}', // URL da rota de logout
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token') // Token de autenticação no header
                },
                data: {
                    _token: '{{ csrf_token() }}' // CSRF token para segurança
                },
                success: function(response) {
                    // Se o logout for bem-sucedido
                    alert(response.message); // Exibe a mensagem de sucesso
                    localStorage.removeItem('token'); // Remove o token do localStorage
                    window.location.href = "{{ route('login.form') }}"; // Redireciona para a página de login
                },
                error: function(xhr, status, error) {
                    // Caso o logout falhe ou o usuário não esteja logado
                    alert(xhr.responseJSON.message || "Erro ao realizar logout"); // Exibe a mensagem de erro
                }
            });
        }

        $(document).ready(function() {
            // Ao clicar no botão de logout
            $('#logoutButton').on('click', function() {
                logout(); // Chama a função de logout
            });
        });
    </script>
</body>
</html>
