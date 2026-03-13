<?php
// データベース接続情報
$host = "localhost";
$user = "todo-app";
$pass = "asdf2469?";
$dbname = "todo_app";

// MySQLサーバーに接続
// mysql → 古いMySQL拡張  // mysqli → Improved（改良版）MySQL拡張
// new mysqli(); MySQLサーバーに接続するオブジェクトが作られる 
// new mysqli( ホスト, ユーザー, パスワード, データベース, ポート, ソケット )
// mysqliオブジェクトに入っているプロパティ(接続状態、サーバー情報、クエリ情報、クライアント情報、文字コード・設定情報)
// ->「このオブジェクトの中の」という意味
// die() は、スクリプトを即座に停止させる関数
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

// データベース作成
// mysqliオブジェクトに入っているメソッド
// 接続：__construct(), close(), select_db()
// クエリ実行：query(), prepare(), bind_param(), execute()
// 結果取得：fetch_assoc()
// $conn->error → 最後に実行した SQL のエラー文字列 が入る
$db =$conn->query("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
if ($db === true) {
    echo "データベース '$dbname' 作成成功または既に存在します。<br>";
} else {
    die("データベース作成エラー: " . $conn->error);
}

// データベース選択
// 操作するデータベースとして設定し、それ以降のSQLクエリは、このデータベース内のテーブルに対して実行される
$conn->select_db($dbname);

// usersテーブル作成
$sql_users = $conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

if ($sql_users === true) {
    echo "テーブル 'users' 作成成功または既に存在します。<br>";
} else {
    die("テーブル 'users' 作成エラー: " . $conn->error);
}

// tasksテーブル作成
$sql_tasks = $conn->query("CREATE TABLE IF NOT EXISTS tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    task VARCHAR(255) NOT NULL,
    content TEXT,
    task_datetime DATETIME,
    status ENUM('未完了','保留','完了') DEFAULT '未完了',
    priority ENUM('null', '高', '中', '低') DEFAULT 'null',
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

if ($sql_tasks === true) {
    echo "テーブル 'tasks' 作成成功または既に存在します。<br>";
} else {
    die("テーブル 'tasks' 作成エラー: " . $conn->error);
}

echo "データベースとテーブル作成完了！";
$conn->close();
?>