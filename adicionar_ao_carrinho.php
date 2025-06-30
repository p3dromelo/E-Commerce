<?php
session_start();
include 'assets/includes/config.php'; // conexão $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $quantidade = intval($_POST['quantidade']);
    $tipo = $_POST['tipo']; // 'jogo' ou 'periferico'

    // Define a URL de redirecionamento de acordo com o tipo
    $redirect = ($tipo === 'periferico') ? 'perifericos.php' : 'produtos.php';

    // Validação de tipo
    if ($tipo !== 'jogo' && $tipo !== 'periferico') {
        $_SESSION['erro'] = "Tipo de produto inválido.";
        header("Location: $redirect");
        exit();
    }

    // Define a tabela com base no tipo
    $tabela = ($tipo === 'jogo') ? 'jogos' : 'perifericos';

    // Consulta estoque disponível no banco
    $stmt = $conn->prepare("SELECT quantidade FROM $tabela WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($estoque_disponivel);
    if (!$stmt->fetch()) {
        $_SESSION['erro'] = ucfirst($tipo) . " não encontrado.";
        $stmt->close();
        header("Location: $redirect");
        exit();
    }
    $stmt->close();

    if ($estoque_disponivel < $quantidade) {
        $_SESSION['erro'] = "Não há estoque suficiente para este $tipo.";
        header("Location: $redirect");
        exit();
    }

    // Inicializa o carrinho se não existir
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Chave composta para diferenciar jogos e periféricos
    $chave = $tipo . '_' . $id;

    $quantidade_no_carrinho = $_SESSION['cart'][$chave]['quantidade'] ?? 0;
    $nova_quantidade = $quantidade_no_carrinho + $quantidade;

    if ($nova_quantidade > $estoque_disponivel) {
        $_SESSION['erro'] = "Você já tem $quantidade_no_carrinho unidade(s) desse $tipo no carrinho. O estoque disponível é $estoque_disponivel.";
        header("Location: $redirect");
        exit();
    }

    // Buscar nome e preço para armazenar no carrinho
    $stmt = $conn->prepare("SELECT nome, preco FROM $tabela WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nome, $preco);
    $stmt->fetch();
    $stmt->close();

    $_SESSION['cart'][$chave] = [
        'id' => $id,
        'tipo' => $tipo,
        'nome' => $nome,
        'preco' => $preco,
        'quantidade' => $nova_quantidade
    ];

    $_SESSION['mostrar_carrinho'] = true;
    header("Location: $redirect");
    exit();
}

header("Location: produtos.php");
exit;
?>
