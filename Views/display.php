<p id="title">
    今日のタスク&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php            
        $date = new DateTime(); // 現在日時
        $w = ['日','月','火','水','木','金','土']; // 日本語曜日
        $dayOfWeek = $w[$date->format('w')]; // 0(日)～6(土)
        echo $date->format('Y年m月d日') . "($dayOfWeek)";
    ?>
</p>
<form id="sortForm" method="GET">
    <label for="sort">並び替え:</label>
    <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="time" <?= ($_GET['sort'] ?? '')=='time' ? 'selected':'' ?>>期日順</option>
        <option value="priority" <?= ($_GET['sort'] ?? '')=='priority' ? 'selected':'' ?>>優先度順</option>
        <option value="status" <?= ($_GET['sort'] ?? '')=='status' ? 'selected':'' ?>>ステータス順</option>  
    </select>
</form>


<div id="display">
    <?php 
        require_once '../datebase/db_connect.php';

        try {
            $today = date('Y-m-d');
            $options = ['未着手', '進行中', '完了'];
            $prioritys = ['高', '中', '低', '-']; // 優先度順に修正
            $sort = $_GET['sort'] ?? 'time';

            // 並び替え用SQL
            switch($sort) {
                case 'priority':
                    $orderSQL = "ORDER BY FIELD(priority, '高','中','低','-'), task_datetime ASC";
                    break;
                case 'status':
                    $orderSQL = "ORDER BY FIELD(status, '未着手','進行中','完了'), task_datetime ASC";
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
                echo $dt->format('H:i') === '00:00' ? "本日中&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>" : $dt->format('H:i')."まで</div>";

                // 優先度フォーム
                echo "<form action='../function/priority_edit.php' method='POST'>";
                echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                echo "<input type='hidden' name='sort' value='". $sort ."'>";
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
                echo "<input type='hidden' name='sort' value='". $sort ."'>";
                echo "<label for='status'>ステータス：</label>";
                echo "<select name='status' onchange='this.form.submit()'>";
                foreach ($options as $option) {
                    $selected = ($task['status'] == $option) ? ' selected' : '';
                    echo "<option value='$option'$selected>$option</option>";
                }
                echo "</select></form>";

                echo "</div></div><hr class='hr'>";
                // 内容
                echo "<div class='task_main'>".nl2br(htmlspecialchars($task['content']))."</div>";

                // 編集・削除
                echo "<div class='task_footer'>";
                echo "<button class='task_edit' 
                        data-id='" . $task['id'] . "' 
                        data-title='" . htmlspecialchars($task['task']) . "'
                        data-content='" . htmlspecialchars($task['content']) . "'
                        data-task_datetime='" . htmlspecialchars($task['task_datetime']) . "'
                        data-status='" . htmlspecialchars($task['status']) . "'
                        data-priority='" . htmlspecialchars($task['priority']) . "'
                        type='button'>
                        詳細編集
                    </button>";
                echo "<div id='modal' class='modal hidden'>
                        <div>あああああ</div>
                    </div>";
                // echo "<form action='index.php?page=edit_task' method='POST'>";
                // echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                // echo "<input type='hidden' name='sort' value='". $sort ."'>";
                // echo "<button class='task_edit' type='submit'>詳細編集</button>";
                // echo "</form>";
                echo "<form action='../function/task_delete.php' method='POST'>";
                echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                echo "<button class='task_delete' type='submit'>削除</button>";
                echo "</form></div></div>";
            }

        } catch (PDOException $e) {
            echo "エラー: " . $e->getMessage();
        }
    ?> 
</div>
