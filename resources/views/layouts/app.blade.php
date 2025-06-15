<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Kanban') }}</title>

    {{-- Bootstrap CSS via CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- jQuery via CDN --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Custom CSS --}}
    <style>
        body {
            background-color: #343a40; /* Fundo escuro */
            color: #fff; /* Texto claro */
            font-family: Arial, sans-serif;
            height: 100vh; /* Garantir que a altura ocupe toda a tela */
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Garantir que ocupe toda a altura da janela */
        }

        .card {
            width: 100%;
            max-width: 400px;  /* Largura máxima do card */
            height: auto;  /* A altura será ajustada conforme o conteúdo */
            margin: 15px;  /* Espaçamento em torno do card */
            border-radius: 8px; /* Bordas arredondadas */
        }

        @media (max-width: 576px) {
            .card {
                width: 100%; /* Card ocupa 100% da largura em telas pequenas */
                padding: 20px; /* Adiciona um pequeno preenchimento no card */
            }
        }

        /* Responsividade para garantir que o formulário seja quadrado em telas maiores */
        @media (min-width: 577px) {
            .card {
                max-width: 400px;  /* Máximo de largura para a tela maior */
                width: 100%;
                height: 400px; /* Para que o card tenha um aspecto de quadrado */
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 20px;
            }
        }
    </style>
</head>
<body class="bg-dark">

{{-- Conteúdo da página --}}
<div class="login-container">
    @yield('content') <!-- Aqui o conteúdo específico da página de login será renderizado -->
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
