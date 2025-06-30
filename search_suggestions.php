<?php
include 'assets/includes/config.php';

$term = isset($_GET['term']) ? trim($_GET['term']) : '';

$suggestions = [];

if ($term !== '') {
    $like = "%{$term}%";

    // Buscar jogos por nome
    $stmt = $conn->prepare("SELECT id, nome FROM jogos WHERE nome LIKE ? LIMIT 5");
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = ["label" => $row['nome'], "type" => "jogo", "id" => $row['id']];
    }
    $stmt->close();

    // Buscar jogos por plataforma
    $stmt = $conn->prepare("SELECT DISTINCT plataforma FROM jogos WHERE plataforma LIKE ? LIMIT 5");
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = ["label" => $row['plataforma'], "type" => "plataforma"];
    }
    $stmt->close();

    // Buscar periféricos por nome
    $stmt = $conn->prepare("SELECT id, nome FROM perifericos WHERE nome LIKE ? LIMIT 5");
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = ["label" => $row['nome'], "type" => "periferico", "id" => $row['id']];
    }
    $stmt->close();

    // Buscar categorias de periféricos
    $stmt = $conn->prepare("SELECT DISTINCT categoria FROM perifericos WHERE categoria LIKE ? LIMIT 5");
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = ["label" => $row['categoria'], "type" => "categoria"];
    }
    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($suggestions);
