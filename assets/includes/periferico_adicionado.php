<?php
session_start();
$success = $_SESSION['add_periferico_success'] ?? 'Periferico adicionado com sucesso!';
unset($_SESSION['add_periferico_success']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="2;url=/PIM_VI_Ordep_Store/admin_page.php"> <!-- Redireciona em 2 segundos -->
    <title>Periferico Adicionado</title>
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
        <p>Você será redirecionado para a página de administração...</p>
    </div>
</body>
</html>
