<?php
/**
 * logoutAction.php
 * ---------------------------------------------------------------
 * Encerra a sessão do usuário (logout) e volta para o login.
 * ---------------------------------------------------------------
 */

session_start();

// Limpa todos os dados da sessão.
$_SESSION = [];

// Remove também o cookie da sessão no navegador.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        "",
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destrói a sessão no servidor.
session_destroy();

header("Location: index.php");
exit;
