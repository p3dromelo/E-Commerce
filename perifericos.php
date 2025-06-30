<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}

include 'assets/includes/config.php';

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$preco_min = isset($_GET['preco_min']) ? floatval($_GET['preco_min']) : 0;
$preco_max = isset($_GET['preco_max']) ? floatval($_GET['preco_max']) : 0;

$perifericos_por_pagina = 10;
$pagina_atual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$offset = ($pagina_atual - 1) * $perifericos_por_pagina;

$valid_categorias = ['mouse', 'teclado', 'fone', 'headset', 'mousepad', 'controle'];
$categoria = in_array(strtolower($categoria), $valid_categorias) ? $categoria : '';

$query_base = "FROM perifericos WHERE 1=1";
$params = [];
$types = "";

if (!empty($categoria)){
    $query_base .= " AND categoria = ?";
    $params[] = $categoria;
    $types .= "s";
}
if ($preco_min > 0){
    $query_base .= " AND preco >= ?";
    $params[] = $preco_min;
    $types .= "d";
}
if ($preco_max > 0){
    $query_base .= " AND preco <= ?";
    $params[] = $preco_max;
    $types .= "d";
}
$stmt_total = $conn->prepare("SELECT COUNT(*) " . $query_base);
if (!empty($params)) {
    $stmt_total->bind_param($types, ...$params);
}
$stmt_total->execute();
$stmt_total->bind_result($total_perifericos);
$stmt_total->fetch();
$stmt_total->close();

$total_paginas = ceil($total_perifericos / $perifericos_por_pagina);

$query = "SELECT * " . $query_base . " ORDER BY nome ASC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$types_pag = $types . "ii";
$params_pag = array_merge($params, [$perifericos_por_pagina, $offset]);
$stmt->bind_param($types_pag, ...$params_pag);
$stmt->execute();
$result = $stmt->get_result();

function buildQueryString($overrides = []) {
    $params = array_merge($_GET, $overrides);
    return http_build_query($params);
}

$quantidade_total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $quantidade_total += $item['quantidade'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Periféricos <?php echo htmlspecialchars($categoria); ?></title>
    <link rel="stylesheet" href="assets/css/style_perifericos.css">
</head>
<body>

<div class="background-overlay"></div>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ordep's Store</title>
    <link rel="stylesheet" href="assets/css/style_periferico.css">
</head>
<body>
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
</div>
</div>

<div class="main-layout">
    <aside class="filter-box">
        <h3>Filtrar por</h3>
        <form method="GET" action="">
            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria">
                <option value="">Todas</option>
                <option value="Mouse">Mouse</option>
                <option value="Teclado">Teclado</option>
                <option value="Fone">Fone</option>
                <option value="Headset">Headset</option>
                <option value="Mousepad">Mousepad</option>
                <option value="Controle">Controle</option>
            </select>
            <br><br>
            <label for="preco_min">Preço mínimo:</label>
            <input type="number" name="preco_min" step="0.01" id="preco_min">
            <br><br>
            <label for="preco_max">Preço máximo:</label>
            <input type="number" name="preco_max" step="0.01" id="preco_max">
            <br><br>
            <button type="submit">🔍 Aplicar</button>
        </form>
    </aside>

    <div class="products">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?php echo htmlspecialchars($row['imagem_path']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>" class="product-img">
                    <div class="price-badge">R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></div>
                </div> <!-- fim da product-image -->

                <div class="product-hover">
                    <div class="product-title"><?php echo htmlspecialchars($row['nome']); ?></div>
                </div>

                <a href="periferico_page.php?id=<?= $row['id'] ?>" class="ver-jogo-btn">Ver Item</a>
                <?php if ($row['quantidade'] > 0): ?>
                    <form method="POST" action="adicionar_ao_carrinho.php" style="margin-top: 5px;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="quantidade" value="1">
                        <input type="hidden" name="tipo" value="periferico"> 
                        <button type="submit" class="add-to-cart-btn">Adicionar</button>
                    </form>
                <?php else: ?>
                    <div class="esgotado-text" style="color: red; font-weight: bold; margin-top: 10px;">Esgotado!</div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
</div>
<div class="pagination">
    <?php if ($pagina_atual > 1): ?>
        <a href="?<?php echo buildQueryString(['pagina' => $pagina_atual - 1]); ?>">&laquo; Anterior</a>
    <?php endif; ?>
    
    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
        <a href="?<?php echo buildQueryString(['pagina' => $i]); ?>"
           class="<?php echo $i == $pagina_atual ? 'active' : ''; ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>

    <?php if ($pagina_atual < $total_paginas): ?>
        <a href="?<?php echo buildQueryString(['pagina' => $pagina_atual + 1]); ?>">Próxima &raquo;</a>
    <?php endif; ?>

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
</div>
</body>
</html>