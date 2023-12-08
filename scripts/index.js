function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('translate-x-0');
}

function openEditModal(id) {
    toggleModal('edit' + id);
}

function openDeleteModal(id) {
    toggleModal('delete' + id);
}

function openAddModal() {
    toggleModal('add');
}

function toggleModal(modalID) {
    document.getElementById(modalID).classList.toggle("hidden");
    document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
    document.getElementById(modalID).classList.toggle("flex");
    document.getElementById(modalID + "-backdrop").classList.toggle("flex");
}
function openAddModal() {
    toggleModal('add');
}