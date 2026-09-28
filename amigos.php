<?php
/**
 * amigos.php
 * ---------------------------------------------------------------
 * Página principal (protegida): lista todos os amigos cadastrados
 * e oferece os botões de cadastrar, editar, excluir e sair.
 * ---------------------------------------------------------------
 */

require_once "verificarAcesso.php";   // Exige login
require_once "conexaoBD.php";         // Conexão com o banco

// Busca todos os amigos em ordem alfabética.
$resultado = $conexao->query("SELECT id, nome, telefone, email FROM amigos ORDER BY nome");
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meus amigos</title>
    <style>
        body   { font: 16px Arial; background: #f4f5f8; margin: 0; color: #222; }
        .wrap  { max-width: 900px; margin: 35px auto; padding: 0 16px; }
        header, .linha {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px #0001;
            margin-top: 16px;
        }
        a, .btn {
            display: inline-block;
            padding: 9px 12px;
            border-radius: 7px;
            text-decoration: none;
            background: #5a4fcf;
            color: white;
            border: 0;
            cursor: pointer;
        }
        a.sec { background: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { text-align: left; padding: 11px; border-bottom: 1px solid #eee; }
        form   { display: inline; }
        .del   { background: #b42318; }
        .muted { color: #666; }
    </style>
</head>
<body>
<main class="wrap">

    <!-- Cabeçalho: saudação e botão de sair -->
    <header>
        <div>
            <h1>Cadastro de amigos</h1>
            <p class="muted">Olá, <?= htmlspecialchars($_SESSION["usuario"]) ?>!</p>
        </div>
        <a class="sec" href="logoutAction.php">Sair</a>
    </header>

    <!-- Lista de amigos -->
    <section class="card">
        <div class="linha">
            <h2>Amigos cadastrados</h2>
            <a href="cadastrarAmigo.php">+ Cadastrar amigo</a>
        </div>

        <?php if (isset($_GET["ok"])): ?>
            <p>Operação concluída com sucesso.</p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($amigo = $resultado->fetch_assoc()): ?>
                <tr>
                    <!-- htmlspecialchars() protege contra XSS ao exibir os dados -->
                    <td><?= htmlspecialchars($amigo["nome"]) ?></td>
                    <td><?= htmlspecialchars($amigo["telefone"] ?? "") ?></td>
                    <td><?= htmlspecialchars($amigo["email"] ?? "") ?></td>
                    <td>
                        <a href="editarAmigo.php?id=<?= (int)$amigo["id"] ?>">Editar</a>

                        <!-- Exclusão via POST com confirmação no navegador -->
                        <form action="excluirAmigo.php" method="post"
                              onsubmit="return confirm('Excluir este amigo?')">
                            <input type="hidden" name="id" value="<?= (int)$amigo["id"] ?>">
                            <button class="btn del" type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </section>

</main>
</body>
</html>
