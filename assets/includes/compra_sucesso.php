<?php
session_start();

// Pode checar se o usuário está logado, opcional
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Compra Finalizada</title>
    <link rel="stylesheet" href="../css/style_compra_sucesso.css">
    <div class="container-center">
    <div class="success-message">
        <h1>Compra realizada com sucesso!</h1>
        <p>Obrigado pela sua compra. Seu pedido está sendo processado.</p>
        <a href="../../user_page.php" class="button">Voltar para a loja</a>
        <br><br>
        <a href="../../perfil.php" class="button secondary">Minha Conta</a><br>
        <a href="https://forms.gle/a9woF7NYvg1opz1GA" target="_blank" class= "button secondary" rel="noopener noreferrer">Avalie o site</a>
    </div>
</div>
</head>
<body style= "background-image: url('/PIM_VI_Ordep_Store/assets/img/Background.jpg');">
    <div class="top-bar">
        <a href="../../user_page.php" class="logo-link">
            <h1>ORDEP'S <span>STORE</span></h1>
        </a>

        <div class="search-section">
        <input id="search-bar" class="search-bar" type="text" placeholder="Pesquise seu produto..." autocomplete="off">
        <div id="suggestions" class="suggestions-box"></div>
        <div class="dropdown">
            <button class="dropbtn">Loja</button>
            <div class="dropdown-content">
                <a href="../../produtos.php">Jogos</a>
                <a href="../../perifericos.php">Periféricos</a>
            </div>
        </div>
    </div>

        <div class="user-info">
        <a href="perfil.php" class="profile-button" title="Ir para perfil">
            <label for="user-info-input">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                    <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                </svg>
            </label>
            <span class="user-name"><?= htmlspecialchars($_SESSION['name']) ?></span>
        </a>

            <button class="cart-button" id="cartBtn" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#e3e3e3" viewBox="0 -960 960 960">
                    <path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM208-800h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Z"/>
                </svg>
            </button>

            <form method="post" action="../../logout.php">
                <button class="logout-button" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#e3e3e3" viewBox="0 -960 960 960">
                        <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/>
                    </svg>
                    Sair
                </button>
            </form>
        </div>
    </div>
</body>
</html>
