<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];

    $imagem = $_FILES['imagem']['name'];
    $galeria = $_FILES['galeria']['name'];

    $imagemPath = "uploads/perifericos/" . basename($imagem);
    $galeriaPath = "uploads/perifericos/" . basename($galeria);

    if (!is_dir("uploads/periferico")) mkdir("uploads/perifericos", 077, true);

    if(
        move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath) &&
        move_uploaded_file($_FILES['galeria']['tmp_name'], $galeriaPath)
    ) {
        $sql = "INSERT INTO perifericos (nome, descricao, categoria, preco, quantidade, imagem_path, galeria_path)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdiss", $nome, $descricao, $categoria, $preco, $quantidade, $imagemPath, $galeriaPath);

if ($stmt->execute()) {
    $_SESSION['add_periferico_sucess'] = "Periferico adicionado com sucesso!";
    header("Location: periferico_adicionado.php");
    exit();

}else {
    echo "Erro ao adicionar periferico: " . $stmt->error;
        }   
        $stmt->close();
    } else {
        echo "Erro ao fazer o upload das imagens.";
    }
}
$conn-close();
?>