
<p id="title">
    今日のタスク&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php
        $date = new DateTime(); // 現在日時
        $w = ['日','月','火','水','木','金','土']; // 日本語曜日
        $dayOfWeek = $w[$date->format('w')]; // 0(日)～6(土)
        echo $date->format('Y年m月d日') . "($dayOfWeek)";
    ?>
</p>

<div id="display">
    <?php 
        require_once '../datebase/db_connect.php';

        try {
            $today = date('Y-m-d');
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE DATE(task_datetime) = :today");
            $stmt->execute(['today' => $today]);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $options = ['未完了', '保留', '完了'];

            foreach ($tasks as $task) {
                echo "<div class='taskDisplay'>";
                echo "<div class='task_head'>";
                echo "<div class='task_name'>".$task['task']."</div>";
                echo "<div class='info_box'>";
                echo "<div class='task_time'>".$task['task_datetime']."</div>";
                echo "<form action='../function/status_edit.php' method='POST'>";
                echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                echo "<select name='status' onchange='this.form.submit()'>";
                foreach ($options as $option) {
                    $selected = ($task['status'] == $option) ? ' selected' : '';
                    echo '<option value="' . $option . '"' . $selected . '>' . $option . '</option>';
                }
                echo "</select>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "<hr class='hr'>";
                echo "<div class='task_main'>".$task['content']."</div>";
                echo "<div class='task_footer'>";
                echo "<a class='task_edit' href=''>編集</a>";
                echo "<form action='../function/task_delete.php' method='POST'>";
                echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                echo "<button class='task_delete' type='submit'>削除</button>";
                echo "</form>";
                echo "<hr>";
                echo "</div>";
                echo "</div>";

            }
        } catch (PDOException $e) {
            echo "エラー: " . $e->getMessage();
        }
    ?> 
</div>