# CRUD Api For Students With CodeIgniter 4 

## Como funciona a aplicação:

A aplicação foi desenvolvida utilizando a tecnologia PHP com o framework CodeIgniter 4. O objetivo é criar um CRUD de alunos, onde é possível cadastrar, listar, editar e excluir alunos.
Utilizando também o banco de dados MySQL para armazenar as informações dos alunos e a biblioteca JWT junto ao Shield do CodeIgniter para autenticação.

## Instalação do projeto

Para instalar a aplicação, basta clonar o repositório e rodar o comando `composer install` para instalar as dependências do projeto.

É necessário PHP 8.1 ou superior e as extensões `intl` e `mbstring` instaladas.

Para baixar usa-se `git clone https://github.com/Antoniosrt/CrudStudentsWithCodeIgniter` entre no diretorio e rode o comando `composer install`.
Após isso, temos que instanciar o banco de dados, para isso precisa-se de um banco de dados MySql.

Para rodar a aplicação, é necessário configurar o arquivo `.env` com as informações do banco de dados e o JWT.
Pode-se copiar o arquivo `env` e renomear para `.env` e configurar as informações do banco de dados e JWT.

A chave JWT pode ser gerada com o comando `php -r 'echo base64_encode(random_bytes(32));'` conforme com a documentação do Shield - CodeIgniter 4.
https://shield.codeigniter.com/addons/jwt/

## Configuração do Ambiente

A aplicação requer que certas variáveis de ambiente sejam definidas para funcionar corretamente. Essas variáveis são definidas no arquivo `.env` na raiz do seu projeto. Abaixo está uma breve explicação de cada uma:

- `CI_ENVIRONMENT`: Esta variável define o ambiente em que sua aplicação está rodando. Pode ser `development` ou `production`. No ambiente `development`, mensagens de erro mais detalhadas serão exibidas.

- `database.default.hostname`: Este é o nome do host do seu servidor de banco de dados. Geralmente é `localhost` para desenvolvimento local.

- `database.default.database`: Este é o nome do seu banco de dados. Você deve criar um banco de dados no seu servidor MySQL e definir esta variável para o seu nome.

- `database.default.username`: Este é o nome de usuário usado para conectar ao seu banco de dados.

- `database.default.password`: Esta é a senha usada para conectar ao seu banco de dados.

- `database.default.DBDriver`: Este é o driver de banco de dados usado para conectar ao seu banco de dados. Para bancos de dados MySQL, deve ser definido como `MySQLi`.

- `database.default.DBPrefix`: Este é um prefixo opcional que será adicionado a todas as suas tabelas de banco de dados. Se você não quiser usar um prefixo, pode deixá-lo como uma string vazia.

- `database.default.port`: Este é o número da porta usado para conectar ao seu servidor de banco de dados. A porta padrão do MySQL é `3306`.

- `authjwt.keys.default.0.secret`: Esta é a chave secreta usada para assinar os tokens JWT para autenticação do usuário. Deve ser uma string longa e aleatória. Você pode gerar uma usando o comando `php -r 'echo base64_encode(random_bytes(32));'`.

Por favor, certifique-se de preencher esses detalhes de acordo com a sua configuração antes de executar a aplicação.

## Migrações
Para criar as tabelas no banco de dados, é necessário rodar as migrações. Para isso, basta rodar o comando `php spark migrate` na raiz do projeto.
E também para ativar as configurações de autenticação do Shield, é necessário rodar o comando `php spark migrate --all` para criar as tabelas necessárias.

Caso deseje reverter as migrações, basta rodar o comando `php spark migrate:rollback` para reverter a última migração.

## Seeds
Para popular o banco de dados com dados iniciais, é necessário rodar as seeds. Para isso, basta rodar o comando `php spark db:seed StudentsSeeder` na raiz do projeto.

## Rodando a aplicação
Para rodar a aplicação, basta rodar o comando `php spark serve` na raiz do projeto. Isso irá iniciar um servidor de desenvolvimento em `http://localhost:8080`.

## API Endpoints
A aplicação possui os seguintes endpoints:
Autenticação:
### - POST - /auth/login - Autentica o usuário e retorna o token JWT
**Body:**
```json
{
    "email": "",
    "password": ""
}
```
#### - POST - /auth/register - Registra um novo usuário
**Body:**
```json
{
    "name": "",
    "email": "",
    "password": ""
}
```

### Students - Rotas protegidas por autenticação JWT utilizado no cabeçalho Authorization Bearer:
**Headers:**
```json
{
    "Authorization": "Bearer {token}"
}
```

#### - GET - /students - Lista todos os alunos (possui paginação com parâmetros page e per_page)
**Query Params:**
```json
{
    "page": 1,
    "per_page": 10
}
```
*

#### - GET - /students/{id} - Lista um aluno específico
**Params:**
```json
{
    "id": 1
}
```
#### - POST - /students - Cadastra um aluno
**Campos Body form-data:**
* fullName
* cpf
* email
* phone
* address_number
* street
* city
* state
* extra - opcional
* photo - Arquivo
#### - POST - /students/{id} - Atualiza um aluno específico
**Params:**
```json
{
    "id": 1
}
```
**Campos Body form-data:**
* fullName
* cpf
* email
* phone
* address_number
* street
* city
* state
* extra - opcional
* photo - Arquivo opcional

#### - DELETE - /students/{id} - Deleta um aluno específico
**Params:**
```json
{
    "id": 1
}
```

Possui uma collection do Postman com os endpoints da aplicação, que pode ser importada para o Postman e testar a aplicação dentro da pasta principal.


## Relatorio 
Atualmente, tenho bastante contato com o framework PHP Symfony, no qual utilizo diversas ferramentas para 
trabalhar com dados, autenticação, rotas, etc. Com isso, escolhi explorar ao máximo os recursos do CodeIgniter 4, como migrações, seeds, rotas, Shield, filtros, visando o aprendizado e a prática do framework. Grande parte do desenvolvimento foi dedicada ao estudo e à prática, para entender o funcionamento do framework e como utilizar os recursos disponíveis.

Optei por uma abordagem JWT e comecei desenvolvendo a autenticação JWT do zero. No entanto,
percebi que o CodeIgniter 4 possui um pacote chamado Shield, que facilita a implementação de autenticação JWT. Por isso, decidi utilizar o Shield para autenticação, mas mantive o código da autenticação JWT que estava desenvolvendo, para demonstrar o processo de desenvolvimento.

Quanto a melhorias futuras, implementaria testes unitários e de integração para garantir a qualidade do código 
e a segurança da aplicação. Além disso, mudaria o armazenamento de imagens em base64 para um diretório no servidor, como o S3 da AWS, 
por exemplo. Ademais, também implementaria um sistema de envio de e-mails para a confirmação de cadastro e
recuperação de senha. (Ficou meio jogada essa parte) Deixei o CORS da aplicação aberto para qualquer origem, mas,
em um ambiente de produção, seria necessário configurar o CORS para aceitar apenas origens específicas, junto ao CorsFilter criado.

## Server Requirements do Code Igniter
Acho imporante deixar esta informação aqui, pois é importante para o funcionamento da aplicação e debug de possíveis problemas.

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> The end of life date for PHP 7.4 was November 28, 2022.
> The end of life date for PHP 8.0 was November 26, 2023.
> If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> The end of life date for PHP 8.1 will be November 25, 2024.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
