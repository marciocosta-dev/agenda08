<?php
/**
 * cadastrarAmigo.php
 * ---------------------------------------------------------------
 * Formulário para cadastrar um novo amigo (página protegida).
 * Valida os campos e grava no banco com consulta preparada.
 * ---------------------------------------------------------------
 */

require_once "verificarAcesso.php";
require_once "conexaoBD.php";

$erro = "";

// ---- Envio do formulário ---------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome     = trim($_POST["nome"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $email    = trim($_POST["email"] ?? "");

    // Validações básicas
    if ($nome === "") {
        $erro = "Informe o nome.";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Informe um e-mail válido ou deixe o campo vazio.";
    } else {
        // Tudo certo: grava no banco.
        $stmt = $conexao->prepare("INSERT INTO amigos (nome, telefone, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $telefone, $email);
        $stmt->execute();

        header("Location: amigos.php?ok=1");
        exit;
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Cadastrar amigo</title>
    <style>
        body  { font: 16px Arial; background: #f4f5f8; }
        .card { max-width: 440px; margin: 40px auto; background: white; padding: 24px; border-radius: 12px; }
        input, button {
            box-sizing: border-box;
            width: 100%;
            padding: 11px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 7px;
        }
        button { background: #5a4fcf; color: white; border: 0; }
        a      { color: #5145cd; }
    </style>
</head>
<body>
    <main class="card">
        <h1>Novo amigo</h1>

        <?php if ($erro): ?>
            <p><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <!-- Em caso de erro, os campos mantêm o que foi digitado -->
        <form method="post">
            <label>Nome *</label>
            <input name="nome" required maxlength="120"
                   value="<?= htmlspecialchars($_POST["nome"] ?? "") ?>">

            <label>Telefone</label>
            <input name="telefone" maxlength="30"
                   value="<?= htmlspecialchars($_POST["telefone"] ?? "") ?>">

            <label>E-mail</label>
            <input type="email" name="email" maxlength="190"
                   value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">

            <button type="submit">Salvar cadastro</button>
        </form>

        <p><a href="amigos.php">Voltar à lista</a></p>
    </main>
</body>
</html>
