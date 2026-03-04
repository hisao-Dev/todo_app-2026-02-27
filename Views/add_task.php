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
                <label for="task_datetime">期日：</label>
                <input type="datetime-local" id="task_datetime" name="task_datetime"><br>
            </div>

            <!-- 優先度 -->
            <div id="unit_2">
                <label for="priority">優先度：</label>
                <select id="priority" name="priority">
                    <option value="高">高</option>
                    <option value="中">中</option>
                    <option value="低">低</option>
                </select><br>
            </div>

            <!-- 送信ボタン-->
            <div>
              <input type="submit" value="新規作成">
            </div>
        </div>
    </form>

</div>