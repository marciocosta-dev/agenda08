<?php
/**
 * conexaoBD.php
 * ---------------------------------------------------------------
 * Cria a conexão com o MySQL usando MySQLi.
 * Este arquivo é incluído (require_once) por todas as páginas que
 * precisam acessar o banco de dados.
 *
 * Ajuste as credenciais abaixo conforme o seu ambiente (XAMPP).
 * ---------------------------------------------------------------
 */

// ---- Configurações do banco ------------------------------------
$host    = "localhost";
$usuario = "root";
$senha   = "";              // Senha do usuário root do MySQL neste XAMPP.
$banco   = "cadastro_amigos";   // Criado ao importar o arquivo banco.sql

// ---- Conexão ----------------------------------------------------
$conexao = new mysqli($host, $usuario, $senha, $banco);

// Interrompe a execução se não for possível conectar.
if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados. Confira conexaoBD.php e importe banco.sql.");
}

// Garante acentuação correta (UTF-8 completo).
$conexao->set_charset("utf8mb4");
