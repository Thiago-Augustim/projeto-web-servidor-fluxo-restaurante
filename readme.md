# Sistema de Gestão - Restaurante

**Desenvolvedores:**\
Thiago de Lima Augustim - RA 2715031\
Nathan Luiz Ferreira dos Santos - RA 1591010\
Kayo Gustavo Oliveira Martins - RA 2713330

Este projeto é um sistema de gestão de restaurante desenvolvido para a matéria de **Desenvolvimento Web Servidor** no curso **Tecnologia em Análise e Desenvolvimento de Sistemas (ADS)** na **UTFPR - Campus Ponta Grossa**. O projeto consiste em um sistema pare gerenciamento de um restaurante, listando mesas que estão ocupadas, livres, ou reservadas. Gerenciamento de pedidos, e comandas de cada mesa.

## Instalação e Execução

Para correr o projeto localmente (XAMPP, WAMP, Laragon), segue estes passos:

1. **Clonar o repositório:**
   ```bash
   git clone https://github.com/Thiago-Augustim/projeto-fluxo-restaurante
   
2. **Copiar para a pasta do Servidor**\
    Copie a pasta do projeto para seu diretório de documentos do Servidor (ex: htdocs).\

3. **Configuração da BASE_URL**\
    No projeto acesse o arquivo **index.php** e certifique que a constante BASE_URL aponta exatamente para a pasta do projeto:

    Exemplo, se a pasta chama **'projeto-fluxo-restaurante'**, a BASE_URL deve ser:
    ```bash
    define('BASE_URL', '/projeto-fluxo-restaurante/public/index.php');

4. **Acesso**
    Para acessar a aplicação, o servidor deve ser iniciado. E acessar a aplicação via web com a **URL**:
    ```bash
    http://localhost/projeto-fluxo-restaurante/public/index.php

5. **Login**\
    Contas para accesso:
    
    **Nível Administrativo (Gerente) - Possui acesso total na aplicação**\
    **Username:** root.gerente\
    **Senha:** 123456

    **Nível Operacional (Garçom) - Permite a gestão do fluxo de atendimento (Mesas, Pedidos e Comandas)**\
     **Username:** root.garcom\
    **Senha:** 123456

    **Nível de Produção (Cozinheiro) - Acesso restrito à tela de pedidos para controle de produção.**\
    **Username:** root.cozinha\
    **Senha:** 123456


   
## Funcionalidades

- **Gestão de Mesas:** Visualização dinâmica de status (Livre, Ocupada, Reservada) com cores indicativas.
- **Controle de Pedidos:** Interface para gerenciamento de pedidos.
- **Controle de comandas:** Visualização de comandas ativas, podendo fecha-las desde que todos os pedidos da mesma estejam concluídos. Visualisação de Comandas Fechadas
- **Controle de funcionários**: Permite o Cadastro de novos funcionários no sistema, gerando o username automaticamente com o primeiro e último nome
- **Segurança:** Sistema permissões baseado em cargos, controlando quem pode visualizar mesas, pedidos, funcionarios ou comandas.

##  Tecnologias Utilizadas

- **Linguagem:** PHP 8.x
- **Frontend:** Bootstrap 5
- **Arquitetura:** MVC (Model-View-Controller)
- **Persistência:** Utilização de Sessões PHP ($_SESSION) para armazenar os dados durante o ciclo de navegação do usuário