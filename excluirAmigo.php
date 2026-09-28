<?php
/**
 * excluirAmigo.php
 * ---------------------------------------------------------------
 * Exclui um amigo pelo ID. Só funciona via POST (botão "Excluir"
 * de amigos.php) e apenas para usuários logados.
 * ---------------------------------------------------------------
 */

require_once "verificarAcesso.php";
require_once "conexaoBD.php";

// Acesso direto pela URL (GET) não exclui nada.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: amigos.php");
    exit;
}

// Valida o ID recebido (precisa ser um número inteiro).
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if ($id) {
    $stmt = $conexao->prepare("DELETE FROM amigos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: amigos.php?ok=1");
exit;
