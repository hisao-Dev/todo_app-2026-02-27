const items = document.querySelectorAll(".task_delete");

items.forEach((el) => {
    el.addEventListener("click",(event)=> {
    const result = confirm("削除しますか？");
    if(!result) {
        event.preventDefault();
    }
});
})

const edit_btn = document.querySelectorAll(".task_edit");
const modal = document.getElementById("modal");
const closeModal = document.getElementById("closeModal");

edit_btn.forEach(btn => {
  btn.addEventListener("click", () => {
    modal.classList.remove("hidden");
  });
});

closeModal.addEventListener("click", () => {
  modal.classList.add("hidden");
});
