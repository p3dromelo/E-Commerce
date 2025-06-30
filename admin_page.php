<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gerenciamento de Jogos</title>
    <link rel="stylesheet" href="assets/css/style_admin.css">
</head>
<body>

<header class="top-bar">
    <h1>ORDEP'S <span>STORE</span></h1>
    <form action="logout.php" method="post">
        <button type="submit" class="logout-button">Sair</button>
    </form>
</header>

<div class="admin-menu">
    <h2>Painel de Administração</h2>
    <a href="admin_gerenciar_jogos.php"><button>Gerenciar Jogos</button></a>
    <a href="admin_gerenciar_perifericos.php"><button>Gerenciar Periféricos</button></a>
</div>

</body>
</html>
