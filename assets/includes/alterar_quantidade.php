<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $quantidade = (int)$_POST['quantidade']; // Sanitiza entrada
    $action = $_POST['action'];
    $tipo = $_POST['tipo']; // 'jogo' ou 'periferico'

    // Validação do tipo
    if (!in_array($tipo, ['jogo', 'periferico'])) {
        echo "Tipo inválido.";
        exit();
    }

    // Define a tabela correta
    $tabela = ($tipo === 'jogo') ? 'jogos' : 'perifericos';

    // Define a SQL baseada na ação
    if ($action == "Adicionar Unidade") {
        $sql = "UPDATE $tabela SET quantidade = quantidade + $quantidade WHERE id = $id";
    } elseif ($action == "Remover Unidade") {
        $sql = "UPDATE $tabela SET quantidade = GREATEST(quantidade - $quantidade, 0) WHERE id = $id";
    } else {
        echo "Ação inválida.";
        exit();
    }

    // Executa a query
    if ($conn->query($sql) === TRUE) {
        echo "Quantidade atualizada com sucesso!";
    } else {
        echo "Erro: " . $conn->error;
    }

    // Redirecionamento com base no tipo
    if ($tipo === 'jogo') {
        header("Location: /PIM_VI_Ordep_Store/admin_gerenciar_jogos.php");
    } else {
        header("Location: /PIM_VI_Ordep_Store/admin_gerenciar_perifericos.php");
    }
    exit();
}

$conn->close();
?>
