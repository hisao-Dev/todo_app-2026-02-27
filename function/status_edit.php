<?php
require_once '../datebase/db_connect.php';

$id = $_POST['id'];
$status = $_POST['status'];
$sort = $_POST['sort']; 

try {
    $sql = "UPDATE tasks SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':id', $id);

    $stmt->execute();
    header("Location: ../Views/index.php?page=display&sort=$sort");
    exit;
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}

?>