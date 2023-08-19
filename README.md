# Sistema de Login em PHP

Este é um simples sistema de login em PHP, que demonstra o processo básico de autenticação de usuários em um site ou aplicativo da web.

## Tecnologias Utilizadas

- PHP: Linguagem de programação usada para desenvolver o sistema de login.
- MySQL: Banco de dados usado para armazenar informações de usuário.
- HTML/CSS: Utilizados para criar a interface do usuário.

## Funcionalidades

- Registro de Novos Usuários: Os usuários podem se registrar fornecendo um nome de usuário, senha e endereço de e-mail válido.
- Autenticação de Usuários: Os usuários podem fazer login com suas credenciais registradas.
- Página de Perfil: Cada usuário tem uma página de perfil onde podem visualizar ou editar suas informações pessoais.

## Como Usar

1. Clone o repositório para sua máquina local usando o comando:

   ```bash
   git clone https://github.com/SamuelJesusDev/login-php.git

2. Configure o Banco de Dados:
   - Crie um banco de dados MySQL e importe o arquivo `database.sql` para criar a tabela de usuários.
   - Edite o arquivo `config.php` e atualize as informações de conexão com o banco de dados.

3. Inicie o Servidor Web:
   - Você pode usar um servidor web local (como XAMPP, WAMP ou MAMP) ou executar o projeto em um ambiente de desenvolvimento PHP embutido usando o comando:

     ```bash
     php -S localhost:8000
     ```

4. Acesse o Aplicativo:
   - Abra um navegador da web e vá para `http://localhost:8000` (ou o URL do seu servidor local) para acessar o sistema de login.

5. Registro e Login:
   - Você pode se registrar como um novo usuário ou fazer login com as credenciais fornecidas durante o registro.

6. Personalização:
   - Personalize o sistema de acordo com suas necessidades, adicione mais campos de perfil, implemente medidas de segurança adicionais, etc.

## Contribuindo

Contribuições são bem-vindas! Se você quiser melhorar ou expandir este sistema de login, sinta-se à vontade para criar uma solicitação de pull.
