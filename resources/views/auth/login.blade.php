<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Kanban</title>

    {{-- Bootstrap CSS via CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- jQuery via CDN --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-dark">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow w-100" style="max-width: 400px;">
        <div class="card-header bg-primary text-white text-center">
            <h4>Login Kanban</h4>
        </div>
        <div class="card-body">

            {{-- Área para mensagens de erro/sucesso --}}
            <div id="loginMessage"></div>

            <form id="loginForm">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: 'http://localhost:8082/api/login',  // Altere para sua rota de API de login
            method: 'POST',
            data: {
                email: $('#email').val(),
                password: $('#password').val()
            },
            success: function(response) {
                console.log(response); // Verifique a resposta do servidor
                if (response.token) {

                    // Salva o token no localStorage
                        localStorage.setItem('token', response.token);

                        // Redireciona para /boards/create, passando o token na requisição
                        $.ajax({
                            url: '/boards/create',
                            method: 'GET',
                            headers: {
                                'Authorization': 'Bearer ' + response.token // Passa o token no cabeçalho
                            },
                            success: function() {
                                window.location.href = '/boards/create';  // Agora o redirecionamento é feito
                            },
                            error: function(xhr) {
                                if (xhr.status === 401) {
                                    alert('Você não está autorizado a acessar essa página.');
                                }
                            }
                        });

                }
            },
            error: function(xhr) {
                let errorMsg = 'Erro ao fazer login.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                $('#loginMessage').html(`
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        ${errorMsg}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
            }
        });
    });

    $(document).on('click', '.btn-close', function() {
        $('#loginMessage').html('');
    });
});
</script>

</body>
</html>
