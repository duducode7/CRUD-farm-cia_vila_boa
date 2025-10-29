<?php
include 'db.php';

// Filtros
$genero = $_GET['genero'] ?? '';
$autor = $_GET['autor'] ?? '';
$ano = $_GET['ano'] ?? '';

$sql = "SELECT l.*, a.nome AS autor_nome FROM livros l JOIN autores a ON l.id_autor=a.id_autor WHERE 1=1";

if ($genero) $sql .= " AND l.genero LIKE '%".$conn->real_escape_string($genero)."%'";
if ($autor) $sql .= " AND a.nome LIKE '%".$conn->real_escape_string($autor)."%'";
if ($ano) $sql .= " AND l.ano_publicacao=".intval($ano);

$result = $conn->query($sql);
?>

<h2>Lista de Livros</h2>
<form method="get">
    Filtro: Gênero <input type="text" name="genero" value="<?= $genero ?>">
    Autor <input type="text" name="autor" value="<?= $autor ?>">
    Ano <input type="number" name="ano" value="<?= $ano ?>">
    <button type="submit">Filtrar</button>
    <a href="read.php">Limpar</a>
</form>

<a href="create.php">Cadastrar novo livro</a>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Gênero</th>
        <th>Ano</th>
        <th>Autor</th>
        <th>Ações</th>
    </tr>
    <?php while($l = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $l['id_livro'] ?></td>
        <td><?= $l['titulo'] ?></td>
        <td><?= $l['genero'] ?></td>
        <td><?= $l['ano_publicacao'] ?></td>
        <td><?= $l['autor_nome'] ?></td>
        <td>
            <a href="update.php?id=<?= $l['id_livro'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $l['id_livro'] ?>" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
