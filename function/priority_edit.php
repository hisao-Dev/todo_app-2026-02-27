<?php
require_once '../datebase/db_connect.php';

$priority = $_POST['priority'];
$id = $_POST['id'];
$sortOrder = isset($_POST['sortOrder']) ? $_POST['sortOrder'] : null; // ------------------------------------------

try {
    $sql = "UPDATE tasks SET priority = :priority WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':priority', $priority);
    $stmt->bindValue(':id', $id);

    $stmt->execute();
    header('Location: ../Views/index.php?page=display&sort=$sortOrder');// --------------------------------
    exit;
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}