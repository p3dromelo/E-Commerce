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
    <link rel="stylesheet" href="assets/css/style_gerenciamento.css">
</head>
<body>
 <header class="top-bar">
    <a href="admin_page.php" class="logo-link">
        <h1>ORDEP'S <span>STORE</span></h1>
</a>
    <form action="logout.php" method="post">
    <button type="submit" class="logout-button">Sair</button>
    
</form>

</header>
    <!-- Espaço entre a top-bar e o conteúdo -->
     
    <div class="main-content">
        <h2>Adicionar Jogo</h2>
        <form action="assets/includes/adicionar_jogo.php" method="post" enctype="multipart/form-data">
            Nome: <input type="text" name="nome" required><br>

            Descrição: <input type="text" name="descricao"><br>

            Categoria:
            <select name="categoria" required>
                <option value="" disabled selected>--Selecione uma Categoria--</option>
                <option value="Ação">Ação</option>
                <option value="Aventura">Aventura</option>
                <option value="Battle-Royale">Battle-Royale</option>
                <option value="Corrida">Corrida</option>
                <option value="Cinematográfico">Cinematográfico</option>
                <option value="Esporte">Esporte</option>
                <option value="FPS">FPS</option>
                <option value="Indie">Indie</option>
                <option value="Luta">Luta</option>
                <option value="MOBA">MOBA</option>
                <option value="RPG">RPG</option>
                <option value="Simulação">Simulação</option>
                <option value="Terror">Terror</option>
            </select><br>

            Plataforma:
            <select name="plataforma" required>
                <option value="" disabled selected>--Selecione uma Plataforma--</option>
                <option value="Playstation">Playstation</option>
                <option value="Xbox">Xbox</option>
                <option value="Steam">Steam</option>
            </select><br>

            Preço: <input type="number" step="0.01" name="preco" required><br>

            Quantidade: <input type="number" name="quantidade" min="1" required><br>

            Banner: <input type="file" name="banner" accept="image/*" required><br>
            <a href="https://www.steamgriddb.com/" target="_blank" rel="noopener noreferrer">Selecionar hero para banner</a><br><br>

            Ícone: <input type="file" name="icone" accept="image/*" required><br>
            <a href="https://www.steamgriddb.com/" target="_blank" rel="noopener noreferrer">Selecionar grid para ícone</a><br>

            <input type="submit" value="Adicionar Jogo">
        </form>

        <h2>Jogos Cadastrados</h2>
        <?php
        include 'assets/includes/config.php';

        $sql = "SELECT * FROM jogos";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<div class='game-box'>";
            echo "<h3>" . $row['nome'] . " (" . $row['plataforma'] . ") - R$ " . number_format($row['preco'], 2, ',', '.') . "</h3>";
            echo "<img src='" . $row['banner_path'] . "' class='banner'><br>"; // Ícone omitido na exibição, mas mantido no banco

            if ($row['quantidade'] == 0) {
                echo "<p><strong>Esgotado!</strong></p>";
            } else {
                echo "<p>Quantidade: " . $row['quantidade'] . "</p>";
            }

            ?>
            <form action="assets/includes/alterar_quantidade.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="hidden" name="tipo" value="jogo">
            <input type="number" name="quantidade" value="1" min="1" required><br>
            <input type="submit" name="action" value="Adicionar Unidade">
            <input type="submit" name="action" value="Remover Unidade">
        </form>
            <?php
            echo "</div><hr>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
