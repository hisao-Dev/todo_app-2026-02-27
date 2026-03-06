<div>
    <p id="title">タスクの新規作成</p>
</div>
<div id="menu_item">
    <form action="../function/create.php" method="POST">
        <!-- タスク名 -->
        <label for="task">タイトル：</label>
        <input type="text" id="task" name="task" required><br>

        <!-- 内容 -->
        <label for="content">内容：</label>
        <textarea id="content" name="content" rows="4" cols="50"></textarea><br>

        <div id="unit">
            <!-- 日付時刻 -->
            <div id="unit_1">
                <label for="task_date">期限：</label>
                <input type="date" id="task_date" name="task_date"><br>

                <label for="task_time">時間（任意）：</label>
                <input type="time" id="task_time" name="task_time"><br>
            </div>

            <!-- 優先度 -->
            <div id="unit_2">
                <label for="priority">優先度：</label>
                <select id="priority" name="priority">
                    <option value="0">設定しない</option>
                    <option value="1">高</option>
                    <option value="2">中</option>
                    <option value="3">低</option>
                </select><br>
            </div>

            <!-- 送信ボタン-->
            <div>
              <input type="submit" value="新規作成">
            </div>
        </div>
    </form>
    <?php
        $message = '';
        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            $message = 'タスクの作成が完了しました';
        }
        if ($message) {
            echo "<p>".$message."</p>";
        }
    ?>
</div>