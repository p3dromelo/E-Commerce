<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}

$conn = new mysqli("localhost", "root", "", "pim_vi_database");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("ID do periférico não especificado.");
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $chave = 'periferico_' . $id;

    // Buscar dados do periferico para armazenar no carrinho
    $stmt = $conn->prepare("SELECT nome, preco, imagem_path, categoria FROM perifericos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result_dados = $stmt->get_result();

    if ($result_dados->num_rows > 0) {
        $periferico_data = $result_dados->fetch_assoc();

        if (!isset($_SESSION['cart'][$chave])) {
            $_SESSION['cart'][$chave] = [
                'nome' => $periferico_data['nome'],
                'preco' => $periferico_data['preco'],
                'icone_path' => $periferico_data['imagem_path'],
                'plataforma' => $periferico_data['categoria'],
                'quantidade' => 1
            ];
        } else {
            $_SESSION['cart'][$chave]['quantidade'] += 1;
        }
    }
    $stmt->close();

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$stmt = $conn->prepare("SELECT * FROM perifericos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Periferico não encontrado.");
}

$perifericos = $result->fetch_assoc();

$quantidade_total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $quantidade_total += $item['quantidade'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($perifericos['nome']) ?> - Detalhes</title>
    <link rel="stylesheet" href="assets/css/style_perifericos_page.css">
</head>
<body>
    <div class="background-overlay"></div>
    <!-- Título -->
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

    <div class="game-details-wrapper">
        <!-- Parte superior -->
        <div class="top-section">
            
            <div class="game-icon" onclick="abrirPopup('<?= htmlspecialchars($perifericos['imagem_path']) ?>')">
    <img src="<?= htmlspecialchars($perifericos['imagem_path']) ?>" alt="<?= htmlspecialchars($perifericos['nome']) ?>" style="cursor: zoom-in;">
            </div>

            <div class="game-info">
                <h2><?= htmlspecialchars($perifericos['nome']) ?></h2>
                <p style="font-size:0px;">
                <p><strong>Categoria:</strong> <?= htmlspecialchars($perifericos['categoria']) ?></p>
                <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($perifericos['descricao'])) ?></p>
            </div>
            <div class="game-price-box">
                <p class="price">R$ <?= number_format($perifericos['preco'], 2, ',', '.') ?></p>
                <form method="POST">
                    <input type="hidden" name="add_to_cart" value="1">
                    <button type="submit" class="add-cart-button">Adicionar ao Carrinho</button>
                </form>
                <form method="POST" action="carrinho.php">
                    <input type="hidden" name="tipo" value="periferico">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($perifericos['id']) ?>">
                    <input type="hidden" name="nome" value="<?= htmlspecialchars($perifericos['nome']) ?>">
                    <input type="hidden" name="preco" value="<?= htmlspecialchars($perifericos['preco']) ?>">
                    <input type="hidden" name="icone_path" value="<?= htmlspecialchars($perifericos['imagem_path']) ?>">
                    <input type="hidden" name="icone_path" value="<?= htmlspecialchars($perifericos['galeria_path']) ?>">
                    <input type="hidden" name="quantidade" value="1">
                </form>
            </div>
        </div>
    <!-- Parte inferior -->
    <div class="game-banner">
        <img src=<?= htmlspecialchars($perifericos['galeria_path']) ?> alt="Banner do periférico">
    </div>

    <div id="popup-overlay" class="popup-overlay" onclick="fecharPopup()">
    <div class="popup-content" onclick="event.stopPropagation();">
        <img id="popup-img" src="" alt="Imagem ampliada">
        <span class="close-btn" onclick="fecharPopup()">×</span>
    </div>
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

<script>
function abrirPopup(imagemSrc) {
    document.getElementById('popup-img').src = imagemSrc;
    document.getElementById('popup-overlay').style.display = 'flex';
}

function fecharPopup() {
    document.getElementById('popup-overlay').style.display = 'none';
}
</script>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
