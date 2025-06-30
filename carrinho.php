<?php
session_start();
include 'assets/includes/config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];
$mostrarCarrinhoVazio = empty($cart);
$produtos = [];

if (!$mostrarCarrinhoVazio) {
    $jogos_ids = [];
    $perifericos_ids = [];

    foreach (array_keys($cart) as $chave) {
        [$tipo, $id] = explode('_', $chave);
        if ($tipo === 'jogo') {
            $jogos_ids[] = (int)$id;
        } elseif ($tipo === 'periferico') {
            $perifericos_ids[] = (int)$id;
        }
    }

    if (!empty($jogos_ids)) {
        $placeholders = implode(',', array_fill(0, count($jogos_ids), '?'));
        $stmt = $conn->prepare("SELECT * FROM jogos WHERE id IN ($placeholders)");
        $stmt->bind_param(str_repeat('i', count($jogos_ids)), ...$jogos_ids);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $produtos['jogo_' . $row['id']] = $row + ['tipo' => 'jogo'];
        }
        $stmt->close();
    }

    if (!empty($perifericos_ids)) {
        $placeholders = implode(',', array_fill(0, count($perifericos_ids), '?'));
        $stmt = $conn->prepare("SELECT * FROM perifericos WHERE id IN ($placeholders)");
        $stmt->bind_param(str_repeat('i', count($perifericos_ids)), ...$perifericos_ids);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $produtos['periferico_' . $row['id']] = $row + ['tipo' => 'periferico'];
        }
        $stmt->close();
    }
}

function getLogoPath($plataforma) {
    $plataforma = strtolower($plataforma);
    switch ($plataforma) {
        case 'playstation': return 'assets/img/Logos/Play5Logo.png';
        case 'steam': return 'assets/img/Logos/SteamLogo.png';
        case 'xbox': return 'assets/img/Logos/XboxLogo.png';
        default: return 'assets/img/defaultLogo.png';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="assets/css/style_do_carrinho.css">
</head>
<body>
    <div class="background-overlay"></div>

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

         <a href="carrinho.php"button class="cart-button" id="cartBtn" type="button" style="padding: 8px; display: inline-block; cursor: pointer; background: none; border: none;">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3" style="pointer-events: none;">
            <path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM208-800h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Z" style="pointer-events: none;"/>
        </svg>
        </button></a>

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
    <br><br>
    <div class="cart-content" style="text-align: center;">
    <?php if ($mostrarCarrinhoVazio): ?>
        <div style="text-align: center; padding: 80px 20px;">
            <img src="assets/img/empty_cart.png" alt="Carrinho Vazio" style="max-width: 150px; opacity: 0.8;">
            <h2>Seu carrinho está vazio 😕</h2>
            <p>Que tal explorar nossos jogos e promoções?</p>
            <a href="user_page.php">
                <button style="
                    background-color: #4CAF50;
                    color: white;
                    padding: 10px 25px;
                    border: none;
                    border-radius: 5px;
                    font-size: 16px;
                    cursor: pointer;
                    margin-top: 15px;
                ">Voltar para a Loja</button>
            </a>
        </div>
    <?php else: ?>
        <br><br><br><br><br>
        <h2>Meu Carrinho</h2>
        <table border="1" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
    <thead>
        <tr>
            <th>Ícone</th>
            <th>Nome</th>
            <th><?php echo 'Plataforma / Categoria'; ?></th>
            <th>Preço Unitário</th>
            <th>Quantidade</th>
            <th>Subtotal</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        foreach ($cart as $chave => $quantidade):
            if (!isset($produtos[$chave])) continue;
            $produto = $produtos[$chave];
            $tipo = $produto['tipo'];
            [$tipo_str, $id] = explode('_', $chave);
            $preco = $produto['preco'];
            
            // Se quantidade for array, pegar valor correto
            $quantidade_valor = is_array($quantidade) ? $quantidade['quantidade'] : $quantidade;

            $subtotal = $quantidade_valor * $preco;
            $total += $subtotal;
        ?>
        
        <tr>
            <td>
                <img src="<?php 
                    echo htmlspecialchars(
                        $tipo === 'periferico' 
                        ? $produto['imagem_path']
                        : $produto['icone_path']); 
                ?>" 
                alt="<?php echo htmlspecialchars($produto['nome']); ?>" 
                style="max-width:80px; height:auto;">
            </td>
            <td><?php echo htmlspecialchars($produto['nome']); ?></td>
            <td><?php echo htmlspecialchars($tipo === 'periferico' ? $produto['categoria'] : $produto['plataforma']); ?></td>
            <td>R$ <?php echo number_format($preco, 2, ',', '.'); ?></td>
            
            <td>
    <form method="post" action="assets/includes/atualizar_carrinho.php" style="display:inline-block; margin-left: 10px;">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
        <input type="hidden" name="acao" value="diminuir">
        <button type="submit">-</button>
    </form>

    <span style="margin: 0 10px;"><?php echo $quantidade_valor; ?></span>

    <form method="post" action="assets/includes/atualizar_carrinho.php" style="display:inline-block;">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
        <input type="hidden" name="acao" value="aumentar">
        <button type="submit">+</button>
    </form>
</td>


            <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
            <td>
                <form method="post" action="assets/includes/remover_do_carrinho.php" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $chave; ?>">
                    <button type="submit">Remover</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold;">Total a Pagar:</td>
            <td colspan="2" style="font-weight: bold; color: green;">R$ <?php echo number_format($total, 2, ',', '.'); ?></td>
        </tr>
    </tbody>
</table>

        <a href="pagamento.php"><button>Finalizar Compra</button></a>
        <br>
        <a href="produtos.php" class="continue-shopping">Continuar Comprando</a>
    <?php endif; ?>
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
