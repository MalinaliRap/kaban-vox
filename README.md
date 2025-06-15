# Desafio Técnico Fullstack - VOX

Este projeto é uma aplicação web de gerenciamento de tarefas estilo **Kanban** (inspirado no Trello), desenvolvida como parte do desafio técnico para a vaga de Desenvolvedor(a) Fullstack na VOX.

## 🛠️ Tecnologias Utilizadas

- **Backend:** Laravel 11 (PHP 8.2+)
- **Banco de Dados:** PostgreSQL
- **Frontend:** HTML + Bootstrap 5
- **Interação:** jQuery + AJAX

---

## 🎯 Funcionalidades

- Autenticação de usuários com login e senha
- Criação de múltiplos quadros de Kanban por usuário
- Dentro de cada quadro:
  - Criação de **categorias** (ex: *To Do*, *Doing*, *Done*)
  - Criação de **tasks** em cada categoria
  - Reorganização das tasks por **arrastar e soltar** (drag and drop) entre categorias
- Atualização automática da posição e categoria da task após movimentação

---

## ⚙️ Como Executar o Projeto

### 1. Clonar o repositório

```bash
git clone [https://github.com/MalinaliRap/kaban-vox.git](https://github.com/MalinaliRap/kaban-vox.git)
```

### 2. Instalar as dependências do Laravel
```bash
composer install
```

### 3. Configurar o aquivo .env e configure o banco
```bash
cp .env.example .env

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Gerar a chave da aplicação
```bash
php artisan key:generate
```

### 5. Rodar as migrations (criação das tabelas)
```bash
php artisan migrate
```

### 6. Rodar o seeder para criar o primeiro usuário
```bash
php artisan db:seed --class=UserSeeder
```

### 7. Rodar o servidor local Laravel
```bash
php artisan serve
```

# pode rodar com xampp, wampp, laragon... 

## ✅ Usuário padrão criado:

- Email: admin@example.com

- Senha: password123

(Se quiser, você pode alterar os dados no arquivo UserSeeder.php antes de rodar o seed.)
