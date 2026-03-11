<?php
require_once '../datebase/db_connect.php';

$status = $_POST['status'];
$id = $_POST['id'];

try {
    $sql = "UPDATE tasks SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':id', $id);

    $stmt->execute();
    header('Location: ../Views/index.php?page=display');
    exit;
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}

?>