<?php
/**
 * verificarAcesso.php
 * ---------------------------------------------------------------
 * Proteção de páginas: inclua este arquivo no início de toda
 * página que exige login. Se o usuário não estiver autenticado,
 * ele é redirecionado para a tela de login (index.php).
 * ---------------------------------------------------------------
 */

// Inicia a sessão apenas se ela ainda não estiver ativa.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Sem "usuario_id" na sessão = usuário não logado.
if (empty($_SESSION["usuario_id"])) {
    header("Location: index.php");
    exit;
}
