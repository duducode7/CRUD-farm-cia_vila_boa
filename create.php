<?php
include 'db.php';

// Buscar autores para o select
$autores = $conn->query("SELECT * FROM autores ORDER BY nome");

// Criar livro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $ano = intval($_POST['ano_publicacao']);
    $id_autor = intval($_POST['id_autor']);
    $anoAtual = date("Y");

    if ($ano < 1501 || $ano > $anoAtual) {
        $erro = "Ano inválido!";
    } else {
        $stmt = $conn->prepare("INSERT INTO livros (titulo, genero, ano_publicacao, id_autor) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $titulo, $genero, $ano, $id_autor);
        $stmt->execute();
        $stmt->close();
        header("Location: read.php");
        exit;
    }
}
?>

<h2>Cadastrar Livro</h2>
<?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<form method="post">
    Título: <input type="text" name="titulo" required><br>
    Gênero: <input type="text" name="genero" required><br>
    Ano de Publicação: <input type="number" name="ano_publicacao" required><br>
    Autor:
    <select name="id_autor" required>
        <?php while($a = $autores->fetch_assoc()): ?>
            <option value="<?= $a['id_autor'] ?>"><?= $a['nome'] ?></option>
        <?php endwhile; ?>
    </select><br>
    <button type="submit">Cadastrar</button>
</form>
<a href="read.php">Voltar à lista</a>
