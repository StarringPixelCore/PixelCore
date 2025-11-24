document.addEventListener('DOMContentLoaded', function () {
  const confirmDeleteModal = document.getElementById('confirmDeleteModal');
  const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

  confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; 
    const url = button.getAttribute('data-url'); 
    confirmDeleteBtn.setAttribute('href', url); 
  });
});
