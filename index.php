<?php
/**
 * index.php
 * ---------------------------------------------------------------
 * Tela de login. O formulário envia os dados para loginAction.php.
 * Se o usuário já estiver logado, vai direto para a lista de amigos.
 * ---------------------------------------------------------------
 */

session_start();

// Já autenticado? Não precisa ver o login de novo.
if (!empty($_SESSION["usuario_id"])) {
    header("Location: amigos.php");
    exit;
}

// "erro=1" é enviado por loginAction.php quando o login falha.
$erro = $_GET["erro"] ?? "";
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Amigos da Gabi</title>
    <style>
        body {
            font: 16px Arial;
            background: #f4f5f8;
            margin: 0;
            display: grid;
            place-items: center;
            min-height: 100vh;
            color: #222;
        }
        .card {
            background: white;
            padding: 28px;
            border-radius: 14px;
            width: min(360px, 85vw);
            box-shadow: 0 8px 30px #0001;
        }
        input, button {
            box-sizing: border-box;
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            background: #5a4fcf;
            color: white;
            border: 0;
            font-weight: bold;
            cursor: pointer;
        }
        .erro  { color: #b42318; }
        small  { color: #555; }
    </style>
</head>
<body>
    <main class="card">
        <h1>Amigos da Gabi</h1>
        <p>Entre para gerenciar seus amigos.</p>

        <?php if ($erro === "1"): ?>
            <p class="erro">Usuário ou senha inválidos.</p>
        <?php endif; ?>

        <form action="loginAction.php" method="post">
            <label>Usuário</label>
            <input name="usuario" autocomplete="username" required maxlength="80">

            <label>Senha</label>
            <input type="password" name="senha" autocomplete="current-password" required>

            <button type="submit">Entrar</button>
        </form>

        <small>Conta demonstrativa: gabi / password</small>
    </main>
</body>
</html>
