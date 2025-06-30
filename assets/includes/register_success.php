<?php
session_start();
$success = $_SESSION['register_success'] ?? '';
unset($_SESSION['register_success']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="2;url=/PIM_VI_Ordep_Store/index.php"> <!-- redireciona em 2 segundos -->
    <title>Cadastro Sucesso</title>
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message-box {
            background-color: #1f1f1f;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid #333;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h2><?= htmlspecialchars($success) ?></h2>
        <p>Você será redirecionado para a tela de login...</p>
    </div>
</body>
</html>
