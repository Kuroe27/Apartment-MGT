<?php
// Action Handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once ('../conn/Crud.php');
    $crud = new Crud();

    if (isset($_POST['edit'])) {
        // Escape and retrieve form data
        $id = $crud->escape_string($_POST['id']);
        $schedule_date = $crud->escape_string($_POST['schedule_date']);

        // Update the schedule_date and status to 'Approved'
        $sql = "UPDATE Maintenance SET schedule_date = '$schedule_date', status = 'Approved' WHERE id = '$id'";

        // Execute the SQL query
        if ($crud->execute($sql)) {
            $_SESSION['message'] = 'Maintenance request updated successfully';
        } else {
            $_SESSION['message'] = 'Cannot update maintenance request: ' . $crud->error(); // Add error message
        }

        // Redirect to maintenance page
        header('location: ../admin/dashboard/maintenance.php');
    } elseif (isset($_POST['delete'])) {
        // Escape and retrieve form data
        $id = $crud->escape_string($_POST['id']);

        // Update status to 'Denied'
        $sql = "UPDATE Maintenance SET status = 'Denied' WHERE id = '$id'";

        // Execute the SQL query
        if ($crud->execute($sql)) {
            $_SESSION['message'] = 'Maintenance request denied';
        } else {
            $_SESSION['message'] = 'Cannot deny maintenance request: ' . $crud->error(); // Add error message
        }

        // Redirect to maintenance page
        header('location: ../admin/dashboard/maintenance.php');
    } else {
        $_SESSION['message'] = 'Invalid action';
        // Specify a valid location to redirect
        header('location: ../admin/dashboard/maintenance.php'); // Redirect to maintenance page or another valid location
    }
}
?>