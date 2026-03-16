const items = document.querySelectorAll(".task_delete");

items.forEach((el) => {
    el.addEventListener("click",(event)=> {
    const result = confirm("削除しますか？");
    if(!result) {
        event.preventDefault();
    }
});
})
