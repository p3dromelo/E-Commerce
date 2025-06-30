<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Carrinho vazio. <a href='produtos.php'>Voltar para loja</a>";
    exit();
}

// 🔐 Validação dos dados do pagamento
$metodo = $_POST['metodo'] ?? '';
$nome_titular = $_POST['nome'] ?? '';

if (empty($metodo)) {
    header('Location: pagamento.php');
    exit();
}

if ($metodo === 'cartao') {
    $numero = $_POST['numero_cartao'] ?? '';
    $validade = $_POST['validade'] ?? '';
    $cvv = $_POST['cvv'] ?? '';
    if (empty($numero) || empty($validade) || empty($cvv)) {
        echo "Dados do cartão incompletos.";
        echo "<br><a href='pagamento.php'>Voltar</a>";
        exit();
    }
}

$email = $_SESSION['email'];
$cart = $_SESSION['cart'];

$conn->begin_transaction();

try {
    foreach ($cart as $chave => $item) {
        list($tipo, $id) = explode('_', $chave);
        $id = (int)$id;
        $quantidade = (int)$item['quantidade'];

        // Define a tabela com base no tipo
        if ($tipo === 'jogo') {
            $tabela = 'jogos';
        } elseif ($tipo === 'periferico') {
            $tabela = 'perifericos';
        } else {
            throw new Exception("Tipo de produto inválido: $tipo");
        }

        // Consulta o estoque atual
        $stmt = $conn->prepare("SELECT quantidade FROM $tabela WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($quantidade_estoque);

        if ($stmt->fetch()) {
            $stmt->close();

            if ($quantidade_estoque < $quantidade) {
                throw new Exception("Estoque insuficiente para o produto ID: $id ($tipo)");
            }

            $nova_quantidade = $quantidade_estoque - $quantidade;

            // Atualiza o estoque
            $stmt_update = $conn->prepare("UPDATE $tabela SET quantidade = ? WHERE id = ?");
            $stmt_update->bind_param("ii", $nova_quantidade, $id);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            $stmt->close();
            throw new Exception("Produto ID $id não encontrado na tabela $tabela.");
        }

        // Insere no histórico de compras
        $stmt_hist = $conn->prepare("INSERT INTO historico_compras 
            (user_email, tipo_produto, produto_id, nome_produto, plataforma_ou_categoria, quantidade, preco_unitario, metodo_pagamento)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $plataformaOuCategoria = $item['plataforma'] ?? $item['categoria'] ?? '';
        $stmt_hist->bind_param("ssissids", 
            $email, 
            $tipo, 
            $id, 
            $item['nome'], 
            $plataformaOuCategoria, 
            $item['quantidade'], 
            $item['preco'], 
            $metodo
        );
        $stmt_hist->execute();
        $stmt_hist->close();
    }

    $conn->commit();
    unset($_SESSION['cart']);
    header("Location: compra_sucesso.php");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    echo "Erro na finalização da compra: " . $e->getMessage();
    echo "<br><a href='../../carrinho.php'>Voltar ao carrinho</a>";
}
?>
