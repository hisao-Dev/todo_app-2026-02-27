<p id="title">
    今日のタスク&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php
        $date = new DateTime(); // 現在日時
        $w = ['日','月','火','水','木','金','土']; // 日本語曜日
        $dayOfWeek = $w[$date->format('w')]; // 0(日)～6(土)
        echo $date->format('Y年m月d日') . "($dayOfWeek)";
    ?>
    <form id="sortForm" method="GET">
        <label for="sort">並び替え:</label>
        <select name="sort" id="sort" onchange="this.form.submit()">
            <option value="time" <?= ($_GET['sort'] ?? '')=='time' ? 'selected':'' ?>>期日順</option>
            <option value="priority" <?= ($_GET['sort'] ?? '')=='priority' ? 'selected':'' ?>>優先度順</option>
            <option value="status" <?= ($_GET['sort'] ?? '')=='status' ? 'selected':'' ?>>ステータス順</option>  
        </select>
    </form>
</p>

<div id="display">
    <?php 
        require_once '../datebase/db_connect.php';

        try {
            $today = date('Y-m-d');
            $options = ['未完了', '保留', '完了', '-'];
            $prioritys = ['高', '中', '低', '-']; // 優先度順に修正
            $sort = $_GET['sort'] ?? 'time'; // デフォルトは期日順

            // 並び替え用SQL
            switch($sort) {
                case 'priority':
                    $orderSQL = "ORDER BY FIELD(priority, '高','中','低','-'), task_datetime ASC";
                    break;
                case 'status':
                    $orderSQL = "ORDER BY FIELD(status, '未完了','保留','-','完了'), task_datetime ASC";
                    break;
                case 'time':
                    $orderSQL = "ORDER BY CASE WHEN TIME(task_datetime) = '00:00:00' THEN 1 ELSE 0 END ASC, task_datetime ASC";
                    break;
                default:
                    $orderSQL = "ORDER BY task_datetime ASC";
            }

            // ソート付きでタスク取得
            $sql = "SELECT * FROM tasks WHERE DATE(task_datetime) = :today $orderSQL";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['today' => $today]);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($tasks as $task) {
                echo "<div class='taskDisplay'>";
                echo "<div class='task_head'>";
                echo "<div class='task_name'>".$task['task']."</div>";
                echo "<div class='info_box'>";
                
                // 期日表示
                $dt = new DateTime($task['task_datetime']);
                echo "<div class='task_time'>期日：";
                echo $dt->format('H:i') === '00:00' ? "本日中</div>" : $dt->format('H:i')."まで</div>";

                // 優先度フォーム
                echo "<form action='../function/priority_edit.php' method='POST'>";
                echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                echo "<input type='hidden' name='sortOrder' value='".$sort."'>";// -----------------------------------------------------------------
                echo "<label for='priority'>優先度：</label>";
                echo "<select name='priority' onchange='this.form.submit()'>";
                foreach ($prioritys as $priority) {
                    $selected = ($task['priority'] == $priority) ? ' selected' : '';
                    echo "<option value='$priority'$selected>$priority</option>";
                }
                echo "</select></form>";

                // ステータスフォーム
                echo "<form action='../function/status_edit.php' method='POST'>";
                echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                echo "<label for='status'>ステータス：</label>";
                echo "<select name='status' onchange='this.form.submit()'>";
                foreach ($options as $option) {
                    $selected = ($task['status'] == $option) ? ' selected' : '';
                    echo "<option value='$option'$selected>$option</option>";
                }
                echo "</select></form>";

                echo "</div></div><hr class='hr'>";
                echo "<div class='task_main'>".$task['content']."</div>";
                echo "<div class='task_footer'>";
                echo "<a class='task_edit' href=''>編集</a>";
                echo "<form action='../function/task_delete.php' method='POST'>";
                echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                echo "<button class='task_delete' type='submit'>削除</button>";
                echo "</form><hr></div></div>";
            }

        } catch (PDOException $e) {
            echo "エラー: " . $e->getMessage();
        }
    ?> 
</div>