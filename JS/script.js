const items = document.querySelectorAll(".task_delete");

items.forEach((el) => {
    el.addEventListener("click",(event)=> {
    const result = confirm("削除しますか？");
    if(!result) {
        event.preventDefault();
    }
});
})

document.querySelectorAll('.task_edit').forEach(btn => {
  btn.addEventListener('click', () => {
    document.getElementById('edit_id').value = btn.dataset.id;
    document.getElementById('edit_title').value = btn.dataset.title;
    document.getElementById('edit_content').value = btn.dataset.content;

    document.getElementById('modal').style.display = 'block';
  });
});