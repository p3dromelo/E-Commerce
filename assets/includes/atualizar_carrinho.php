<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do POST
    $id = $_POST['id'] ?? '';
    $acao = $_POST['acao'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    // Quantidade enviada, se for atualização direta
    $quantidade = isset($_POST['quantidade']) ? intval($_POST['quantidade']) : 1;

    // Validação básica
    if (!$id || !$tipo || !in_array($tipo, ['jogo', 'periferico'])) {
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit();
    }

    // Monta a chave da sessão
    $chave = $tipo . '_' . $id;

    // Busca dados do produto no banco para pegar estoque, nome, preco, ícone
    if ($tipo === 'jogo') {
        $stmt = $conn->prepare("SELECT nome, preco, quantidade, icone_path FROM jogos WHERE id = ?");
    } else {
        $stmt = $conn->prepare("SELECT nome, preco, quantidade, imagem_path FROM perifericos WHERE id = ?");
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nome, $preco, $estoque, $icone_path);
    $stmt->fetch();
    $stmt->close();

    if (!$nome) { // Produto não encontrado
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit();
    }

    // Quantidade atual no carrinho
    $quantidade_atual = $_SESSION['cart'][$chave]['quantidade'] ?? 0;

    // Se não existe, inicializa no carrinho com 0
    if (!isset($_SESSION['cart'][$chave])) {
        $_SESSION['cart'][$chave] = ['quantidade' => 0];
    }

    // Executa a ação pedida
    if ($acao === 'aumentar') {
        if ($quantidade_atual < $estoque) {
            $_SESSION['cart'][$chave]['quantidade'] = $quantidade_atual + 1;
        }
    } elseif ($acao === 'diminuir') {
        $novo = $quantidade_atual - 1;
        if ($novo <= 0) {
            unset($_SESSION['cart'][$chave]);
        } else {
            $_SESSION['cart'][$chave]['quantidade'] = $novo;
        }
    } elseif ($acao === 'atualizar') {
        if ($quantidade <= 0) {
            unset($_SESSION['cart'][$chave]);
        } else {
            $_SESSION['cart'][$chave]['quantidade'] = min($quantidade, $estoque);
        }
    }

    // Redireciona para a página anterior
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
    exit();
}
