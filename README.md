# Sistema de Gestão e Agendamentos

Gestão House foi criado para gerenciar cadastros e agendamentos para setor público e privado, conectado com o WhatsApp através da API da Z-API.

## Instalação

Use o link do Github (https://github.com/robertoferreira/gestao-camara-secretaria).
Obs.: Add "." no final caso tenha criado tenha criado a pasta e tenha clonado, caso contrário não use o ponto, ele irá criar a pasta automaticamente.

```bash
git clone git@github.com:robertoferreira/milena-cad.git
```

```bash
composer install
```

Cria o .env para adicionar as variaveis de ambiente
```bash
cp .env.exemple .env
```

```bash
php artisan key:generate
```

```bash
php artisan migrate --seed
```

## Como usar

```env
No arquivo .env

# adicionar as variáveis de ambientes caso não tenha:

Z_API_INSTANCE=
Z_API_TOKEN=
Z_API_CLIENT_TOKEN=

OPENCAGE_API_KEY=5fda91c1dbad4b26bf5a191622518e5d
Obs.: Essa chave da Opencage é da House Criative, usar a do clinete
```



## Licença

[Privada Pertencente a House Criative LTDA](https://housecriative.com.br)
