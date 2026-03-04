<?php
require_once '../datebase/db_connect.php';

// POSTデータを受け取る
$task = $_POST['task'];
$content = $_POST['content'];
$task_datetime = $_POST['task_datetime'];
$priority = $_POST['priority'];

try {
    $sql = "INSERT INTO tasks (task, content,task_datetime,priority) VALUES (:task, :content, :task_datetime, :priority)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':task', $task);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':task_datetime', $task_datetime);
    $stmt->bindParam(':priority', $priority);
    $stmt->execute();

    echo "保存完了";
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>