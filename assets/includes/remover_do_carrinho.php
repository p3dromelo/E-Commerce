<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe a chave composta como string
    $chave = $_POST['id'] ?? '';
    if ($chave && isset($_SESSION['cart'][$chave])) {
        unset($_SESSION['cart'][$chave]);
    }
}

header('Location: ../../carrinho.php');
exit();
