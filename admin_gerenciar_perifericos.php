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
    <title>Admin - Gerenciamento de Periféricos</title>
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

    <div class="main-content">
        <h2>Adicionar Periférico</h2>
        <form action="assets/includes/adicionar_periferico.php" method="post" enctype="multipart/form-data">
            Nome: <input type="text" name="nome" required><br>

            Descrição: <input type="text" name="descricao"><br>

            Categoria:
            <select name="categoria" required>
                <option value="" disabled selected>--Selecione o tipo--</option>
                <option value="Mouse">Mouse</option>
                <option value="Teclado">Teclado</option>
                <option value="Fone">Fone</option>
                <option value="Headset">Headset</option>
                <option value="Mousepad">Mousepad</option>
                <option value="Controle">Controle</option>
            </select><br>
            Marca: <input type="text" name="marca" required><br>

            Preço: <input type="number" step="0.01" name="preco" required><br>

            Quantidade: <input type="number" name="quantidade" min="1" required><br>

            Imagem: <input type="file" name="imagem" accept="image/*" required><br>

            Galeria: <input type="file" name="galeria" accept="image/*" required><br>

            <input type="submit" value="Adicionar Periférico">
    </form>

    <h2>Periféricos Cadastrados</h2>
    <?php
    include 'assets/includes/config.php';

    $sql = "SELECT * FROM perifericos";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()){
        echo "<div class='game-box'>";
        echo "<h3>" .$row['nome'] . " (" . $row['categoria'] . ") - R$ " .
        number_format($row['preco'], 2, ',', '.') . "</h3>";
        echo "<img src='" . $row['imagem_path'] . "' class='imagem'><br>";

        if ($row['quantidade'] == 0) {
                echo "<p><strong>Esgotado!</strong></p>";
        } else {
            echo "<p>Quantidade: " . $row['quantidade'] . "</p>";
        }

        ?>
                <form action="assets/includes/alterar_quantidade.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="hidden" name="tipo" value="periferico">
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
