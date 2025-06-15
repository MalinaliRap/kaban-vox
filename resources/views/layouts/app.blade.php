<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Kanban') }}</title>

    <!-- CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- JS do Bootstrap (com bundle que inclui Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Link para o Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Link para o jQuery UI CDN - DRAG AND DROP -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- link css public -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Link para o Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


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
    <div id="content" class="container mt-5" style="display:none;">
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

        function validateToken() {
            // Verificar se o token está presente no localStorage
            var token = localStorage.getItem('token');

            if (!token) {
                // Se não houver token, redireciona para a tela de login
                window.location.href = "{{ route('login.form') }}";
            } else {
                // Se o token estiver presente, valida com o backend
                $.ajax({
                    url: '{{ url("api/validate-token") }}', // Rota para validar o token
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token // Envia o token no header
                    },
                    success: function(response) {
                        // Se o token for válido, mostra o conteúdo
                        if (response.valid) {
                            $('#content').show(); // Exibe o conteúdo protegido
                        } else {
                            // Se o token não for válido, redireciona para o login
                            window.location.href = "{{ route('login.form') }}";
                        }
                    },
                    error: function(xhr, status, error) {
                        // Se houver erro ao verificar o token, redireciona para o login
                        window.location.href = "{{ route('login.form') }}";
                    }
                });
            }
        }

        $(document).ready(function() {
            // Ao clicar no botão de logout
            validateToken();

            $('#logoutButton').on('click', function() {
                logout(); // Chama a função de logout
            });
        });
    </script>
</body>
</html>
