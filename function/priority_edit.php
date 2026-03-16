<?php
require_once '../datebase/db_connect.php';

$id = $_POST['id'];
$priority = $_POST['priority'];
$sort = $_POST['sort']; 

try {
    $sql = "UPDATE tasks SET priority = :priority WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':priority', $priority);
    $stmt->bindValue(':id', $id);

    $stmt->execute();
    header("Location: ../Views/index.php?page=display&sort=$sort");
    exit;
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}