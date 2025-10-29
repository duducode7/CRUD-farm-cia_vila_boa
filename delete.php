<?php
include 'db.php';

$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM livros WHERE id_livro=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: read.php");
exit;
?>
