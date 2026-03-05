
<p id="title">今日のタスク</p>

<div id="display">
    <?php 
        require_once '../datebase/db_connect.php';

        try {
            $stmt = $pdo->query("SELECT * FROM tasks");
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($tasks as $task) {
                echo "<div id='taskDisplay'>";
                echo "<div id='task_head'>";
                echo "<div id='task_name'>".$task['task']."</div>";
                echo "<div id='info_box'>";
                echo "<div id='task_time'>".$task['task_datetime']."</div>";
                echo "<div id='task_status'>".$task['status']."</div>";
                echo "</div>";
                echo "</div>";
                echo "<div id='task_main'>".$task['content']."</div>";
                echo "<div id='task_footer'>";
                echo "<a id='task_edit' href=''>編集</a>";
                echo "<a id='task_delete' href=''>削除</a>";
                echo "<hr>";
                echo "</div>";
                echo "</div>";
            }

        } catch (PDOException $e) {
            echo "エラー: " . $e->getMessage();
        }
    ?> 
</div>