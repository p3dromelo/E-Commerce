<?php
include 'assets/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $quantidade_remover = $_POST['quantidade_remover'];

    // Consulta a quantidade atual
    $sql = "SELECT quantidade FROM jogos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $quantidade_atual = $row['quantidade'];

        $nova_quantidade = $quantidade_atual - $quantidade_remover;
        if ($nova_quantidade < 0) $nova_quantidade = 0;

        // Atualiza a nova quantidade
        $sql_update = "UPDATE jogos SET quantidade = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $nova_quantidade, $id);

        if ($stmt_update->execute()) {
            header("Location: admin_page.php");
            exit();
        } else {
            echo "Erro ao atualizar a quantidade.";
        }
    } else {
        echo "Jogo não encontrado.";
    }
}
$conn->close();
?>
