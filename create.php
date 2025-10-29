<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $quantidade = intval($_POST['quantidade']);
    $preco = floatval($_POST['preco']);
    $tipo = $_POST['tipo'] ?? '';
    $erro = '';
    if ($quantidade < 0) {
        $erro = "Quantidade inválida!";
    } else if ($preco < 0) {
        $erro = "Preço inválido!";
    } else if (empty($tipo)) {
        $erro = "Tipo do medicamento é obrigatório!";
    } else {
        $stmt = $conn->prepare("INSERT INTO medicamentos (nome_medicamento, estoque_medicamento, preco_medicamento, tipo_medicamento) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sids", $nome, $quantidade, $preco, $tipo);
        $stmt->execute();
        $stmt->close();
        header("Location: read.php");
        exit;
    }
}
?>

<h2>Cadastrar Medicamento</h2>
<?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<form method="post">
    Nome: <input type="text" name="nome" required><br>
    Quantidade: <input type="number" name="quantidade" required><br>
    Preço: <input type="number" step="0.01" name="preco" required><br>
    Tipo: <input type="text" name="tipo" required><br>
    
    <button type="submit">Cadastrar</button>
</form>
<a href="index.php">Voltar à lista</a>
