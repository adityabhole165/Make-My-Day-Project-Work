// delete_modal.js

// JavaScript to handle passing menu_id to delete.php
document.querySelectorAll('.open-delete-modal').forEach(item => {
    item.addEventListener('click', function() {
        let menuId = this.getAttribute('data-menu-id');
        let deleteLink = document.getElementById('deleteLink');
        deleteLink.setAttribute('href', 'delete.php?c=' + menuId);
    });
});
