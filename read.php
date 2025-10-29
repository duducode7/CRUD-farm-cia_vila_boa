<?php
include 'db.php';

$nome = $_GET['nome'] ?? '';

$sql = "SELECT * FROM medicamentos WHERE 1=1";
if ($nome) $sql .= " AND nome LIKE '%".$conn->real_escape_string($nome)."%'";

$result = $conn->query($sql);
?>

<h2>Lista de Medicamentos</h2>
<form method="get">
    Filtro: Nome <input type="text" name="nome" value="<?= $nome ?>">
    <button type="submit">Filtrar</button>
    <a href="read.php">Limpar</a>
</form>

<a href="create.php">Cadastrar novo medicamento</a>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Quantidade</th>
        <th>Preço</th>
    </tr>
    <?php while($m = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $m['id_medicamento'] ?></td>
        <td><?= $m['nome'] ?></td>
        <td><?= $m['quantidade'] ?></td>
        <td><?= number_format($m['preco'], 2, ',', '.') ?></td>
        <td>
            <a href="update.php?id=<?= $m['id_medicamento'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $m['id_medicamento'] ?>" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
