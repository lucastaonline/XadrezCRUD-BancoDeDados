# XadrezCRUD-BancoDeDados
CRUD - Create Remove Update Delete.
Esta parte de meu trabalho de banco de dados consiste em desenvolver um sistema CRUD para acessar o banco de dados e realizar operações básicas em cima dele.

## Tecnologias utilizadas

- Puramente e simplesmente: Laravel.

## Requisitos

- Você deve ter laravel instalado na sua máquina, logo, deve ter o composer também.

## Criando o banco de dados

Crie um banco de dados com o nome de XadrezDB (recomendado).
Ao clonar o projeto você verá que temos um script com a criação do banco em um arquivo .sql .
Utilizamos o MariaDB no projeto então a sintaxe será compatível com o mesmo.

## Clonando o projeto

### Ao clonar o projeto você deve ir a pasta do projeto (XadrezCRUD) e rodar os seguintes comandos.

Você deverá rodar este comando para instalar as dependências do laravel/composer.

```
$ composer install
```

Copie o .env-example para um arquivo com o nome de .env.
Nele você deverá setar o caminho para seu banco de dados assim como suas credenciais.
Recomendamos que crie um banco com o nome de XadrezDB, para seguir o padrão.

```
$ cp .env-example .env
```

Gere a chave do php artisan.

```
$ php artisan key:generate
```

## Rodando a aplicação

Para rodar a aplicação basta rodar o comando:

```
$ php artisan serve
```

E acessar o endereço setada na sua máquina para o laravel (comumente 127.0.0.1:8000).
