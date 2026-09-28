<div align="center">

# 👯 Amigos da Gabi

**Sistema de cadastro de amigos com login, feito em PHP + MySQL para rodar no XAMPP.**

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?logo=mysql&logoColor=white)
![XAMPP](https://img.shields.io/badge/XAMPP-local-FB7A24?logo=xampp&logoColor=white)
![Status](https://img.shields.io/badge/status-did%C3%A1tico-5a4fcf)

</div>

---

## 📌 Sobre o projeto

Um CRUD simples e didático para gerenciar uma lista de amigos (nome, telefone e e-mail), protegido por login. O projeto demonstra boas práticas básicas de segurança em PHP:

- 🔐 Senhas armazenadas com **hash bcrypt** (`password_hash` / `password_verify`)
- 🛡️ **Consultas preparadas** (MySQLi) contra SQL Injection
- 🧼 **Escape de saída** (`htmlspecialchars`) contra XSS
- 🔑 Sessão regenerada após o login e destruída no logout
- ✅ Validação de dados (campos obrigatórios e e-mail)

## ✨ Funcionalidades

| Recurso | Descrição |
|---|---|
| Login / Logout | Acesso protegido por usuário e senha |
| Listar amigos | Ordem alfabética, com mensagem de sucesso |
| Cadastrar | Nome (obrigatório), telefone e e-mail |
| Editar | Atualiza os dados de um amigo existente |
| Excluir | Com confirmação no navegador, via `POST` |

## 🧰 Tecnologias

- PHP 8+ (MySQLi)
- MySQL / MariaDB
- HTML5 + CSS3
- Apache (via XAMPP)

## 🚀 Como rodar no XAMPP

1. **Inicie** o **Apache** e o **MySQL** no XAMPP Control Panel.
2. **Copie** a pasta `sistema_amigos_gabi` para:
   ```
   C:\xampp\htdocs\
   ```
3. **Crie o banco**: abra o [phpMyAdmin](http://localhost/phpmyadmin), vá na aba **SQL**, cole o conteúdo de [`banco.sql`](banco.sql) e execute.
4. **Confira a conexão** em [`conexaoBD.php`](conexaoBD.php):
   ```php
   $host    = "localhost";
   $usuario = "root";
   $senha   = "root";            // ajuste para a senha do seu MySQL
   $banco   = "cadastro_amigos";
   ```
   > 💡 No XAMPP recém-instalado o `root` costuma vir **sem senha**. Se for o seu caso, use `$senha = "";`.
5. **Acesse**: <http://localhost/sistema_amigos_gabi/>

## 🔑 Login demonstrativo

| Usuário | Senha |
|---|---|
| `gabi` | `password` |

> ⚠️ Altere a senha antes de usar em qualquer ambiente compartilhado.

## 🗂️ Estrutura de arquivos

```
sistema_amigos_gabi/
├── index.php            # Tela de login
├── loginAction.php      # Valida usuário e senha, abre a sessão
├── logoutAction.php     # Encerra a sessão
├── verificarAcesso.php  # Bloqueia páginas para quem não está logado
├── conexaoBD.php        # Conexão com o MySQL
├── amigos.php           # Lista de amigos (página principal)
├── cadastrarAmigo.php   # Formulário de novo amigo
├── editarAmigo.php      # Formulário de edição
├── excluirAmigo.php     # Exclusão de amigo
├── banco.sql            # Script de criação do banco e tabelas
└── README.md
```

## 🗄️ Banco de dados

**`usuarios`**

| Coluna | Tipo | Observação |
|---|---|---|
| `id` | INT | PK, auto incremento |
| `usuario` | VARCHAR(80) | Único |
| `senha_hash` | VARCHAR(255) | Hash bcrypt |
| `criado_em` | TIMESTAMP | Data de criação |

**`amigos`**

| Coluna | Tipo | Observação |
|---|---|---|
| `id` | INT | PK, auto incremento |
| `nome` | VARCHAR(120) | Obrigatório |
| `telefone` | VARCHAR(30) | Opcional |
| `email` | VARCHAR(190) | Opcional |
| `criado_em` | TIMESTAMP | Data de criação |

## 🩹 Problemas comuns

<details>
<summary><b>"Usuário ou senha inválidos" com gabi / password</b></summary>

Reimporte o `banco.sql` (ou rode o `UPDATE` abaixo no Workbench/phpMyAdmin) para gravar o hash correto:

```sql
USE cadastro_amigos;
UPDATE usuarios
SET senha_hash = '$2y$10$5Wbtmol4S4VMo3h6.R1n5eXWY10cqlx/aGpcfXZ8uJRihqpiiorJK'
WHERE usuario = 'gabi';
```
</details>

<details>
<summary><b>"Falha na conexão com o banco de dados"</b></summary>

Confira usuário e senha em `conexaoBD.php`, se o MySQL está iniciado no XAMPP e se o `banco.sql` foi importado.
</details>

## 🔒 Antes de publicar de verdade

Este é um projeto **didático para uso local**. Para produção, adicione:

- Proteção **CSRF** nos formulários
- Limite de tentativas de login
- **HTTPS**
- Usuário MySQL com permissões mínimas (não use `root`)
- Credenciais fora da pasta pública (variáveis de ambiente / arquivo fora do `htdocs`)

## 📄 Licença

Projeto de uso educacional. Sinta-se livre para estudar e adaptar.
