<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "pim_vi_database";

// Criação da conexão
$conn = new mysqli($host, $user, $password, $database);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
?>
