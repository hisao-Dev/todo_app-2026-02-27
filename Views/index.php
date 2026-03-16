<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/main.css">
    <title>タスク管理アプリ</title>
    <script src="../JS/script.js" defer></script>
</head>
<body>
<?php
require_once 'header.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'display';
require_once 'main.php';

require_once 'footer.php';    
?>
</body>
</html>