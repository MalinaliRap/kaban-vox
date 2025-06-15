@extends('layouts.guest')

@section('content')
    <div class="card shadow w-100" style="max-width: 400px; margin: 0 auto;">
        <div class="card-header bg-primary text-white text-center">
            <h4>Login Kanban</h4>
        </div>
        <div class="card-body">
            {{-- Formulário de login --}}
            <form id="loginForm">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" value="{{ old('email') }}" required>
                    <div id="emailError" class="text-danger" style="display: none;"></div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required>
                    <div id="passwordError" class="text-danger" style="display: none;"></div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#loginForm').submit(function(event) {
            event.preventDefault(); // Impede o envio do formulário

            var email = $('#email').val();
            var password = $('#password').val();

            $.ajax({
                url: '{{ url("api/login") }}',  // Certifique-se de que a URL seja a correta para a API de login
                method: 'POST',
                data: {
                    email: email,
                    password: password,
                    _token: '{{ csrf_token() }}'  // Inclui o CSRF token para segurança
                },
                success: function(response) {
                    if (response.token) {  // Verifique se o token foi retornado
                        // Seta o token no localStorage
                        localStorage.setItem('token', response.token);

                        // Redireciona ou realiza outras ações após o login
                        window.location.href = "{{ route('dashboard') }}";  // Redireciona para o dashboard após login
                    } else {
                        alert('Erro no login: ' + response.message);  // Exibe mensagem de erro se o login falhar
                    }
                },
                error: function(xhr, status, error) {
                    // Se ocorrer erro, exibe a mensagem de erro no console
                    alert('Erro: ' + (xhr.responseJSON.message || 'Erro desconhecido'));
                }
            });
        });
    });
</script>
@endsection

