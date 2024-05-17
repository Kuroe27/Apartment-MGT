
<?php
session_start();
include_once('../conn/Crud.php');

$crud = new Crud();

if(isset($_POST['edit'])) {
    $id = $crud->escape_string($_POST['id']);
    $schedule_date = $crud->escape_string($_POST['schedule_date']);

    // Automatically change status to 'Approved' when editing
    $sql = "UPDATE Maintenance SET schedule_date = '$schedule_date', status = 'Approved' WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Maintenance request updated successfully';
    } else {
        $_SESSION['message'] = 'Cannot update maintenance request: ' . $crud->error(); // Add error message
    }

    header('location: ../admin/dashboard/maintenance.php');
} elseif(isset($_POST['delete'])) {
    $id = $crud->escape_string($_POST['id']);

    // Change status to 'Denied' when deleting
    $sql = "UPDATE Maintenance SET status = 'Denied' WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Maintenance request denied';
    } else {
        $_SESSION['message'] = 'Cannot deny maintenance request: ' . $crud->error(); // Add error message
    }

    header('location: ../admin/dashboard/maintenance.php');
} else {
    $_SESSION['message'] = 'Invalid action';
    header('location: '); // Specify a valid location
}
?>
