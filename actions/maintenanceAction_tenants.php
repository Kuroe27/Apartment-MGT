<?php
session_start();
include_once('../conn/Crud.php');

$crud = new Crud();

if(isset($_POST['addMaintenance'])) {
    // Get the logged-in tenant ID (assuming you have this stored in a session)
    $tenant_id = $_SESSION['tenant_id']; // Update this according to your actual session variable name

    // Get the description from the form
    $description = $crud->escape_string($_POST['description']);

    // Insert the maintenance request into the database
    $sql = "INSERT INTO `Maintenance` (`tenant_id`, `description`, `status`, `schedule_date`)
            VALUES ('$tenant_id', '$description', 'Pending', NULL)";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Maintenance request added successfully';
    } else {
        $_SESSION['message'] = 'Failed to add maintenance request';
    }

    header('location: ../tenants/dashboard/maintenance.php');
} else {
    $_SESSION['message'] = 'Invalid action';
    header('location: ');
}
?>
