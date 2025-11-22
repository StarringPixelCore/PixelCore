document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('confirmDeleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const name = button.getAttribute('data-name');
            
            document.getElementById('deleteUserName').textContent = name;
            document.getElementById('confirmDeleteBtn').href = url;
        });
    }
});