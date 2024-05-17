<?php
session_start();
include_once ('../conn/Crud.php');

$crud = new Crud();
if (isset($_POST['add'])) {
    $visitor_name = $crud->escape_string($_POST['visitor_name']);
    $visitor_email = $crud->escape_string($_POST['visitor_email']);
    $visitor_phone = $crud->escape_string($_POST['visitor_phone']);
    $visit_date = $crud->escape_string($_POST['visit_date']);
    $purpose = $crud->escape_string($_POST['purpose']);
    $tenant_id = $_SESSION['tenant_id'];

    $sql = "INSERT INTO `Visitor_Log`(`visitor_name`, `visitor_email`, `visitor_phone`, `visit_date`, `purpose`, `tenant_id`)
            VALUES ('$visitor_name', '$visitor_email', '$visitor_phone', '$visit_date', '$purpose', '$tenant_id')";

    if ($crud->execute($sql)) {
        $_SESSION['message'] = 'Visitor added successfully';
    } else {
        $_SESSION['message'] = 'Cannot add visitor';
    }

    header('location: ../tenants/dashboard/');
} elseif (isset($_POST['edit'])) {
    $id = $crud->escape_string($_POST['id']);
    $visitor_name = $crud->escape_string($_POST['visitor_name']);
    $visitor_email = $crud->escape_string($_POST['visitor_email']);
    $visitor_phone = $crud->escape_string($_POST['visitor_phone']);
    $visit_date = $crud->escape_string($_POST['visit_date']);
    $purpose = $crud->escape_string($_POST['purpose']);

    $sql = "UPDATE Visitor_Log SET 
            visitor_name = '$visitor_name', 
            visitor_email = '$visitor_email', 
            visitor_phone = '$visitor_phone', 
            visit_date = '$visit_date', 
            purpose = '$purpose'
            WHERE id = '$id'";

    if ($crud->execute($sql)) {
        $_SESSION['message'] = 'Visitor updated successfully';
    } else {
        $_SESSION['message'] = 'Cannot update visitor';
    }

    header('location: ../admin/dashboard/visitor.php');
} elseif (isset($_POST['delete'])) {
    $id = $crud->escape_string($_POST['id']);
    $sql = "DELETE FROM Visitor_Log WHERE id = '$id'";

    if ($crud->execute($sql)) {
        $_SESSION['message'] = 'Visitor deleted successfully';
    } else {
        $_SESSION['message'] = 'Cannot delete visitor';
    }

    header('location: ../admin/dashboard/visitor.php');
} else {
    $_SESSION['message'] = 'Invalid action';
    header('location: ');
}
?>