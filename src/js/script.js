document.addEventListener("DOMContentLoaded", function () {
    const editModalElement = document.getElementById('editTodoModal');
    if (!editModalElement) {
        console.error("Modal element not found.");
        return;
    }

    let editModal = new bootstrap.Modal(editModalElement);
    const editForm = document.getElementById("editTodoForm");

    document.querySelectorAll(".edit-todo").forEach(button => {
        button.addEventListener("click", function () {
            const id = this.dataset.id;
            fetch(`/todos/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Todo not found");
                    }
                    return response.json();
                })
                .then(todo => {
                    document.getElementById("editTodoId").value = todo.id;
                    document.getElementById("editTitle").value = todo.title;
                    document.getElementById("editDescription").value = todo.description;
                    editModal.show();
                })
                .catch(error => {
                    console.error("Error fetching todo:", error);
                    alert("Failed to load todo for editing.");
                });
        });
    });

    editForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const id = document.getElementById("editTodoId").value;
        fetch(`/todos/${id}/update`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                title: document.getElementById("editTitle").value,
                description: document.getElementById("editDescription").value
            })
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                console.error("Failed to update todo");
                alert("Failed to update todo.");
            }
        });
    });
});
