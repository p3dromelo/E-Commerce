<?php
session_start();
include 'assets/includes/config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "Carrinho vazio. <a href='produtos.php'>Voltar para a loja</a>";
    exit();
}

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
    <title>Pagamento</title>
    <link rel="stylesheet" href="assets/css/style_pagamentos.css">
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
    <br><br><br><br><br><br>
    <div class="payment-container">
<form action="assets/includes/finalizar_compra.php" method="post">
    <label class="payment-label" for="metodo">Método de Pagamento:</label>
    <select class="payment-input" name="metodo" required>
        <option value="">--Escolha um Método de Pagamento--</option>
        <option value="pix">PIX</option>
        <option value="cartao">Cartão de Crédito</option>
    </select><br>

    <div id="dados-cartao" style="display: none;">
        <label class="payment-label" for="nome">Nome do Titular:</label>
        <input class="payment-input" type="text" name="nome" required>

        <label class="payment-label">CPF:</label>
        <input class="payment-input" type="text" name="cpf" maxlength="14" placeholder="123.456.789-01">
        <button type="button" class="payment-button small-button" onclick="gerarCPF('dados-cartao')">Gerar CPF</button>

        <label class="payment-label">Número do Cartão:</label>
        <input class="payment-input" type="text" name="numero_cartao" maxlength="19" placeholder="1234 5678 9012 3456">
        <button type="button" class="payment-button small-button" onclick="gerarCartao()">Gerar Cartão</button>

        <label class="payment-label">Validade:</label>
        <input class="payment-input" type="text" name="validade" placeholder="MM/AA">

        <label class="payment-label">CVV:</label>
        <input class="payment-input" type="text" name="cvv" pattern="\d{3}">
    </div>

    <div id="dados-pix" style="display: none;">
        <label class="payment-label">Nome Completo:</label>
        <input class="payment-input" type="text" name="nome" required>

        <label class="payment-label">CPF:</label>
        <input class="payment-input" type="text" name="cpf" maxlength="14" placeholder="123.456.789-01">
        <button type="button" class="payment-button small-button" onclick="gerarCPF('dados-pix')">Gerar CPF</button>
    </div>

    <button class="payment-button" type="submit">Confirmar Pagamento</button>
</form>


    <br><a href="carrinho.php">Voltar ao carrinho</a>
    <script>
    const metodoPagamento = document.querySelector('select[name="metodo"]');
    const cartaoFields = document.getElementById('dados-cartao');
    const pixFields = document.getElementById('dados-pix');

    metodoPagamento.addEventListener('change', function () {
        const isCartao = this.value === 'cartao';
        const isPix = this.value === 'pix';

        cartaoFields.style.display = isCartao ? 'block' : 'none';
        pixFields.style.display = isPix ? 'block' : 'none';

        // Remove 'required' de todos os inputs primeiro
        document.querySelectorAll('#dados-cartao input, #dados-pix input').forEach(input => {
            input.required = false;
        });

        // Adiciona 'required' apenas nos inputs do método escolhido
        if (isCartao) {
            cartaoFields.querySelectorAll('input').forEach(input => {
                input.required = true;
            });
        } else if (isPix) {
            pixFields.querySelectorAll('input').forEach(input => {
                input.required = true;
            });
        }
    });
</script>

<script>
    // Formatador de CPF
    function formatarCPF(cpf) {
        return cpf
            .replace(/\D/g, '') // Remove não-dígitos
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }

    // Formatador de cartão de crédito
    function formatarCartao(numero) {
        return numero
            .replace(/\D/g, '') // Remove não-dígitos
            .replace(/(\d{4})(?=\d)/g, '$1 ') // Adiciona espaço a cada 4 dígitos
            .trim();
    }

    // Aplicar formatação ao digitar
    document.querySelector('input[name="cpf"]').addEventListener('input', function () {
        this.value = formatarCPF(this.value);
    });

    document.querySelector('input[name="numero_cartao"]').addEventListener('input', function () {
        this.value = formatarCartao(this.value);
    });

    // Botão de gerar CPF formatado
    function gerarCPF(targetDivId) {
        function rand(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        const n = [];
        for (let i = 0; i < 9; i++) n.push(rand(0, 9));

        let d1 = n.map((v, i) => v * (10 - i)).reduce((a, b) => a + b);
        d1 = (d1 % 11 < 2) ? 0 : 11 - (d1 % 11);
        n.push(d1);

        let d2 = n.map((v, i) => v * (11 - i)).reduce((a, b) => a + b);
        d2 = (d2 % 11 < 2) ? 0 : 11 - (d2 % 11);
        n.push(d2);

        const cpf = n.join('');
        const cpfInput = document.querySelector(`#${targetDivId} input[name="cpf"]`);
        if (cpfInput) cpfInput.value = formatarCPF(cpf);
    }

    // Botão de gerar número de cartão formatado
    function gerarCartao() {
        let numero = '';
        for (let i = 0; i < 16; i++) {
            numero += Math.floor(Math.random() * 10);
        }

        const cartaoInput = document.querySelector('input[name="numero_cartao"]');
        if (cartaoInput) cartaoInput.value = formatarCartao(numero);
    }
</script>

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
