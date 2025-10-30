<?php
include 'db.php';

$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM medicamentos WHERE id_medicamento =?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: read.php");
exit;
?>
