# Sistema de Gestão - Restaurante

*Desenvolvedores:*\
Thiago de Lima Augustim - RA 2715031\
Nathan Luiz Ferreira dos Santos - RA 1591010\
Kayo Gustavo Oliveira Martins - RA 2713330

Este projeto é um sistema de gestão de restaurante desenvolvido para a matéria de *Desenvolvimento Web Servidor* no curso *Tecnologia em Análise e Desenvolvimento de Sistemas (ADS)* na *UTFPR - Campus Ponta Grossa*. O projeto consiste em um sistema pare gerenciamento de um restaurante, listando mesas que estão ocupadas, livres, ou reservadas. Gerenciamento de pedidos, e comandas de cada mesa.

## Instalação e Execução

Para correr o projeto localmente (XAMPP, WAMP, Laragon), segue estes passos:

1. *Clonar o repositório:*
   bash
   git clone https://github.com/Thiago-Augustim/projeto-fluxo-restaurante
   

2. *Copiar para a pasta do Servidor*\
    Copie a pasta do projeto para seu diretório de documentos do Servidor (ex: htdocs).\

3. *Instalar as dependências*\
    Com o Composer instalado, rode dentro da pasta do projeto:
   bash
   composer install
   

4. *Criar o Banco de Dados*\
    Crie um banco chamado fluxo_restaurante no MySQL e importe o arquivo database/banco.sql. Ele já vem com a estrutura das tabelas e os usuários iniciais.\
    No arquivo database/Database.php você pode ajustar o host, usuário e senha caso sejam diferentes do padrão (root sem senha).

5. *Configuração da BASE_URL*\
    No projeto acesse o arquivo *public/index.php* e certifique que a constante BASE_URL aponta para o endereço do projeto no servidor.\
    Caso esteja usando um virtual host local (como projeto-fluxo-restaurante.test):
    php
    define('BASE_URL', 'http://projeto-fluxo-restaurante.test/');
    
    Caso esteja usando XAMPP sem virtual host:
    php
    define('BASE_URL', 'http://localhost/projeto-fluxo-restaurante/public/');
    

6. *Acesso*\
    Para acessar a aplicação, o servidor deve ser iniciado. E acessar a aplicação via web com a *URL* configurada na BASE_URL.

7. *Login*\
    Contas para acesso:

    *Nível Administrativo (Gerente) - Possui acesso total na aplicação*\
    *Username:* root.gerente\
    *Senha:* 123456

    *Nível Operacional (Garçom) - Permite a gestão do fluxo de atendimento (Mesas, Pedidos e Comandas)*\
    *Username:* root.garcom\
    *Senha:* 123456

    *Nível de Produção (Cozinheiro) - Acesso restrito à tela de pedidos para controle de produção.*\
    *Username:* root.cozinha\
    *Senha:* 123456


   
## Funcionalidades

- *Gestão de Mesas:* Visualização dinâmica de status (Livre, Ocupada, Reservada) com cores indicativas. Permite cadastrar, alterar o status e excluir mesas, com todas as informações salvas no banco de dados.
- *Controle de Pedidos:* Interface para gerenciamento de pedidos por mesa, com controle de status (aguardando, em preparo, pronto, cancelado).
- *Controle de comandas:* Visualização de comandas ativas, podendo fechá-las desde que todos os pedidos da mesma estejam concluídos. Histórico de comandas fechadas com valor total.
- *Controle de funcionários*: Permite o cadastro de novos funcionários no sistema, gerando o username automaticamente com o primeiro e último nome. As senhas são armazenadas de forma segura com hash.
- *Segurança:* Sistema de permissões baseado em cargos, controlando quem pode visualizar mesas, pedidos, funcionários ou comandas.

##  Tecnologias Utilizadas

- *Linguagem:* PHP 8.x
- *Frontend:* Bootstrap 5
- *Arquitetura:* MVC (Model-View-Controller)
- *Banco de Dados:* MySQL via PDO
- *Autoload:* Composer
- *Persistência:* Banco de dados MySQL para todos os dados do sistema

## O que foi feito na segunda parte do projeto

Na segunda etapa, o projeto saiu do uso de sessões PHP para armazenar os dados e passou a usar um banco de dados MySQL de verdade. Abaixo estão as principais mudanças realizadas:

- *Banco de dados:* Criamos as tabelas mesas, pedidos, comandas, comandas_fechadas e funcionarios.
- *Conexão com o banco:* Classe Database que gerencia a conexão com o MySQL, e trait ConexaoBD que é usada nos models pra acessar essa conexão.
- *Organização dos controllers:* Convertemos todos os controllers em classes PHP.
- *Autoload com Composer:* PUtilização de autoload do Composer, que carrega as classes automaticamente.