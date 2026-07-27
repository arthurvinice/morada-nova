# Morada Nova

Sistema SaaS para gestão de imóveis de aluguel, desenvolvido com Laravel.

O objetivo da plataforma é centralizar o gerenciamento de imóveis, contratos, locatários, proprietários, pagamentos e demais processos relacionados à administração imobiliária.

## Tecnologias

- PHP 8.x
- Laravel 12
- MySQL/PostgreSQL
- Bootstrap 5
- Livewire
- Alpine.js

## Instalação

Clone o repositório:

```bash
git clone git@github.com:arthurvinice/morada-nova.git


Acesse a pasta do projeto:

```bash
cd morada-nova
```

Instale as dependências do PHP:

```bash
composer install
```

Crie o arquivo de ambiente:

```bash
cp .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Configure as informações do banco de dados no arquivo `.env`.

Execute as migrations:

```bash
php artisan migrate
```

Caso queira povoar o banco de dados:

```bash
php artisan db:seed
```

Inicie o servidor:

```bash
php artisan serve
```

A aplicação estará disponível em:

```
http://localhost:8000
```

## Estrutura do projeto

- Gestão de imóveis
- Gestão de proprietários
- Gestão de inquilinos
- Contratos de locação
- Controle financeiro
- Dashboard administrativo
- Cadastro de usuários e permissões

> Algumas funcionalidades ainda estão em desenvolvimento.

## Variáveis de ambiente

As principais configurações estão no arquivo `.env`:

```env
APP_NAME="Morada Nova"
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

## Licença

Este projeto é privado.

Todos os direitos reservados.