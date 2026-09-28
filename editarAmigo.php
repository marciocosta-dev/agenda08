<?php
/**
 * editarAmigo.php
 * ---------------------------------------------------------------
 * Formulário para editar um amigo existente (página protegida).
 * Recebe o ID pela URL (?id=), carrega os dados atuais e, ao
 * enviar o formulário, atualiza o registro no banco.
 * ---------------------------------------------------------------
 */

require_once "verificarAcesso.php";
require_once "conexaoBD.php";

// ---- Valida o ID da URL ----------------------------------------
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: amigos.php");
    exit;
}

// ---- Carrega os dados atuais do amigo --------------------------
$stmt = $conexao->prepare("SELECT nome, telefone, email FROM amigos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$amigo = $stmt->get_result()->fetch_assoc();

if (!$amigo) {
    http_response_code(404);
    exit("Amigo não encontrado.");
}

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
        $erro = "E-mail inválido.";
    } else {
        // Tudo certo: atualiza o registro.
        $upd = $conexao->prepare("UPDATE amigos SET nome=?, telefone=?, email=? WHERE id=?");
        $upd->bind_param("sssi", $nome, $telefone, $email, $id);
        $upd->execute();

        header("Location: amigos.php?ok=1");
        exit;
    }

    // Em caso de erro, mantém no formulário o que foi digitado.
    $amigo = ["nome" => $nome, "telefone" => $telefone, "email" => $email];
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Editar amigo</title>
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
        <h1>Editar amigo</h1>

        <?php if ($erro): ?>
            <p><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Nome *</label>
            <input name="nome" required maxlength="120"
                   value="<?= htmlspecialchars($amigo["nome"]) ?>">

            <label>Telefone</label>
            <input name="telefone" maxlength="30"
                   value="<?= htmlspecialchars($amigo["telefone"] ?? "") ?>">

            <label>E-mail</label>
            <input type="email" name="email" maxlength="190"
                   value="<?= htmlspecialchars($amigo["email"] ?? "") ?>">

            <button type="submit">Salvar alterações</button>
        </form>

        <p><a href="amigos.php">Cancelar e voltar</a></p>
    </main>
</body>
</html>
