<?php
include 'db.php';

$id = intval($_GET['id']);
$livro = $conn->query("SELECT * FROM livros WHERE id_livro=$id")->fetch_assoc();
$autores = $conn->query("SELECT * FROM autores ORDER BY nome");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $ano = intval($_POST['ano_publicacao']);
    $id_autor = intval($_POST['id_autor']);
    $anoAtual = date("Y");

    if ($ano < 1501 || $ano > $anoAtual) {
        $erro = "Ano inválido!";
    } else {
        $stmt = $conn->prepare("UPDATE livros SET titulo=?, genero=?, ano_publicacao=?, id_autor=? WHERE id_livro=?");
        $stmt->bind_param("ssiii", $titulo, $genero, $ano, $id_autor, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: read.php");
        exit;
    }
}
?>

<h2>Editar Livro</h2>
<?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<form method="post">
    Título: <input type="text" name="titulo" value="<?= $livro['titulo'] ?>" required><br>
    Gênero: <input type="text" name="genero" value="<?= $livro['genero'] ?>" required><br>
    Ano de Publicação: <input type="number" name="ano_publicacao" value="<?= $livro['ano_publicacao'] ?>" required><br>
    Autor:
    <select name="id_autor" required>
        <?php while($a = $autores->fetch_assoc()): ?>
            <option value="<?= $a['id_autor'] ?>" <?= $a['id_autor']==$livro['id_autor']?'selected':'' ?>><?= $a['nome'] ?></option>
        <?php endwhile; ?>
    </select><br>
    <button type="submit">Atualizar</button>
</form>
<a href="read.php">Voltar à lista</a>
