<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $plataforma = $_POST['plataforma'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];

    // Pegando nomes dos arquivos corretamente
    $banner = $_FILES['banner']['name'];
    $icone = $_FILES['icone']['name']; 

    $bannerPath = "uploads/banners/" . basename($banner);
    $iconePath = "uploads/icones/" . basename($icone);

    // Certifique-se que os diretórios existem
    if (!is_dir("uploads/banners")) mkdir("uploads/banners", 0777, true);
    if (!is_dir("uploads/icones")) mkdir("uploads/icones", 0777, true);

    // Fazendo upload das imagens
    if (
        move_uploaded_file($_FILES['banner']['tmp_name'], $bannerPath) &&
        move_uploaded_file($_FILES['icone']['tmp_name'], $iconePath)
    ) {
        // Use prepared statement para segurança contra SQL Injection
        $sql = "INSERT INTO jogos (nome, descricao, categoria, plataforma, preco, quantidade, banner_path, icone_path)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdiss", $nome, $descricao, $categoria, $plataforma, $preco, $quantidade, $bannerPath, $iconePath);

if ($stmt->execute()) {
    $_SESSION['add_game_success'] = "Jogo adicionado com sucesso!";
    header("Location: jogo_adicionado.php"); // Caminho relativo dentro de assets/includes
    exit();

}else {
            echo "Erro ao adicionar jogo: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erro ao fazer o upload das imagens.";
    }
}
$conn->close();
?>
