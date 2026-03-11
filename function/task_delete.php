<?php
require_once '../datebase/db_connect.php';

$id = $_POST['id'];
var_dump($id);
try {
    $sql = "DELETE FROM tasks WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':id', $id);

    $stmt->execute();
    header('Location: ../Views/index.php?page=display&status=delete');
    exit;
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}

?>
