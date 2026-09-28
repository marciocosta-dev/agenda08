<?php
/**
 * loginAction.php
 * ---------------------------------------------------------------
 * Processa o formulário de login enviado por index.php.
 * Busca o usuário no banco e confere a senha com password_verify()
 * (a senha é guardada como hash bcrypt, nunca em texto puro).
 * ---------------------------------------------------------------
 */

session_start();
require_once "conexaoBD.php";

// Só aceita requisições POST (envio do formulário).
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// ---- Dados do formulário ---------------------------------------
$usuario = trim($_POST["usuario"] ?? "");
$senha   = $_POST["senha"] ?? "";

// ---- Busca o usuário (consulta preparada evita SQL Injection) --
$stmt = $conexao->prepare("SELECT id, usuario, senha_hash FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$conta     = $resultado->fetch_assoc();

// ---- Confere a senha -------------------------------------------
if ($conta && password_verify($senha, $conta["senha_hash"])) {
    // Novo ID de sessão após o login (protege contra session fixation).
    session_regenerate_id(true);
    $_SESSION["usuario_id"] = (int)$conta["id"];
    $_SESSION["usuario"]    = $conta["usuario"];

    header("Location: amigos.php");
    exit;
}

// Usuário ou senha incorretos: volta ao login com aviso de erro.
header("Location: index.php?erro=1");
exit;
