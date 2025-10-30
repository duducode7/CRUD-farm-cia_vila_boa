<?php
include 'db.php';

$id = intval($_GET['id']);
$medicamento = $conn->query("SELECT * FROM medicamentos WHERE id_medicamento = $id")->fetch_assoc();

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
        $stmt = $conn->prepare("UPDATE medicamentos SET nome_medicamento=?, estoque_medicamento=?, preço_medicamento=?, tipo_medicamento=? WHERE id_medicamento=?");
        $stmt->bind_param("sidsi", $nome, $quantidade, $preco, $tipo, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: read.php");
        exit;
    }
}
?>

<h2>Editar Medicamento</h2>

<?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

<form method="post">
    Nome: <input type="text" name="nome" value="<?= htmlspecialchars($medicamento['nome_medicamento']) ?>" required><br>
    Quantidade: <input type="number" name="quantidade" value="<?= htmlspecialchars($medicamento['estoque_medicamento']) ?>" required><br>
    Preço: <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars($medicamento['preço_medicamento']) ?>" required><br>
    
    Tipo:
    <select name="tipo" required>
        <option value="" disabled>Selecione o tipo</option>
        <option value="A" <?= $medicamento['tipo_medicamento'] == 'A' ? 'selected' : '' ?>>Tipo A</option>
        <option value="B" <?= $medicamento['tipo_medicamento'] == 'B' ? 'selected' : '' ?>>Tipo B</option>
        <option value="C" <?= $medicamento['tipo_medicamento'] == 'C' ? 'selected' : '' ?>>Tipo C</option>
    </select><br><br>

    <button type="submit">Atualizar</button>
</form>

<a href="read.php">Voltar à lista</a>
