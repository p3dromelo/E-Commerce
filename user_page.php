<?php
session_start();

if(!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}

include 'assets/includes/config.php';

// Buscar 5 jogos aleatórios
$jogos = [];
$jogosStmt = $conn->query("SELECT id, nome, preco, plataforma, banner_path FROM jogos ORDER BY RAND() LIMIT 5");
if ($jogosStmt) {
    while ($row = $jogosStmt->fetch_assoc()) {
        $jogos[] = $row;
    }
}

// Buscar 5 periféricos aleatórios
$perifericos = [];
$perifericosStmt = $conn->query("SELECT id, nome, preco, imagem_path FROM perifericos ORDER BY RAND() LIMIT 5");
if ($perifericosStmt) {
    while ($row = $perifericosStmt->fetch_assoc()) {
        $perifericos[] = $row;
    }
}

$quantidade_total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $quantidade_total += $item['quantidade'];
    }
}

require_once 'assets/includes/config.php';

$stmt = $conn->prepare("SELECT id, banner_path FROM jogos WHERE banner_path IS NOT NULL AND banner_path != '' LIMIT 5");
$stmt->execute();
$result = $stmt->get_result();


?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ordep's Store</title>
    <link rel="stylesheet" href="assets/css/style_home_page.css">
</head>
<body>
    <!-- Cabeçalho e Top Bar -->
<div class="background-overlay"></div>
<div class="top-bar">
    <a href="user_page.php" class="logo-link">
    <h1>ORDEP'S <span>STORE</span></h1>
</a>

    <div class="search-section">
        <input id="search-bar" class="search-bar" type="text" placeholder="Pesquise seu produto..." autocomplete="off">
        <div id="suggestions" class="suggestions-box"></div>
        <div class="dropdown">
            <button class="dropbtn">Loja</button>
            <div class="dropdown-content">
                <a href="produtos.php">Jogos</a>
                <a href="perifericos.php">Periféricos</a>
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
        <span class="user-name"><?php echo $_SESSION['name']; ?></span>
    </a>
        <a href="carrinho.php" class="cart-container">
            <?php if ($quantidade_total > 0): ?>
                <div class="cart-badge"><?= $quantidade_total ?></div>
            <?php endif; ?>
            <button class="cart-button" id="cartBtn" type="button" style="padding: 8px; display: inline-block; cursor: pointer; background: none; border: none;">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3" style="pointer-events: none;">
                    <path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM208-800h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Z" style="pointer-events: none;"/>
                </svg>
            </button>
        </a>
        <form method="post" action="logout.php">
            <button class="logout-button" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                    <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/>
                </svg>
                Sair
            </button>
        </form>
    </div>
</div>


<!-- Conteúdo principal -->
<div class="page-container">
    <div class="carousel-wrapper"> 
        <div class="carousel">
           <div class="carousel-images" id="carousel-images">
            <?php while ($row = $result->fetch_assoc()): ?>
                <a href="game_page.php?id=<?= $row['id'] ?>">
                    <img src="<?= htmlspecialchars($row['banner_path']) ?>" alt="Banner do jogo <?= $row['id'] ?>">
                </a>
            <?php endwhile; ?>
        </div>

            <div class="carousel-buttons">
                <button onclick="prevSlide()">❮</button>
                <button onclick="nextSlide()">❯</button>
            </div>
            <div class="carousel-dots" id="carousel-dots"></div>
        </div>
    </div>
</div>

<script src="assets/js/carousel.js"></script>

<div class="highlight-section">
    <h2>Jogos do dia:</h2>
</div>
<div class="products">
    <!-- Jogos -->
    <?php foreach ($jogos as $jogo): ?>
        <div class="product-card">
            <div class="product-image">
                <a href="game_page.php?tipo=jogo&id=<?= $jogo['id'] ?>">
                    <img src="<?= htmlspecialchars($jogo['banner_path']) ?>" alt="<?= htmlspecialchars($jogo['nome']) ?>" class="product-img">
                </a>
                <div class="price-badge">R$ <?= number_format($jogo['preco'], 2, ',', '.') ?></div>
                <div class="product-hover">
                    <div class="product-title"><?= htmlspecialchars($jogo['nome']) ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<div class="highlight-section">
    <h2>Periféricos do dia:</h2>
</div>
<div class="products">
    <!-- Periféricos -->
    <?php foreach ($perifericos as $item): ?>
        <div class="product-card">
            <div class="product-image">
                <a href="periferico_page.php?tipo=periferico&id=<?= $item['id'] ?>">
                    <img src="<?= htmlspecialchars($item['imagem_path']) ?>" alt="<?= htmlspecialchars($item['nome']) ?>" class="product-img">
                </a>
                <div class="price-badge">R$ <?= number_format($item['preco'], 2, ',', '.') ?></div>
                <div class="product-hover">
                    <div class="product-title"><?= htmlspecialchars($item['nome']) ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", () => {
    const searchBar = document.getElementById("search-bar");
    const suggestionsBox = document.getElementById("suggestions");

    searchBar.addEventListener("input", () => {
        const query = searchBar.value;
        if (query.length < 2) {
            suggestionsBox.innerHTML = '';
            return;
        }

        fetch(`search_suggestions.php?term=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                suggestionsBox.innerHTML = '';
                data.forEach(item => {
                    const div = document.createElement("div");
                    div.textContent = item.label;
                    div.addEventListener("click", () => {
                        if (item.type === "jogo") {
                            window.location.href = `game_page.php?id=${item.id}`;
                        } else if (item.type === "plataforma") {
                            window.location.href = `produtos.php?plataforma=${encodeURIComponent(item.label)}`;
                        } else if (item.type === "periferico") {
                            window.location.href = `periferico_page.php?id=${item.id}`;
                        } else if (item.type === "categoria") {
                            window.location.href = `perifericos.php?categoria=${encodeURIComponent(item.label)}`;
                        }
                    });
                    suggestionsBox.appendChild(div);
                });
            });
    });

    document.addEventListener("click", (e) => {
        if (!searchBar.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.innerHTML = '';
        }
    });
});
</script>


</body>
</html>
