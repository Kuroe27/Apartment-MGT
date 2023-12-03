<?php
session_start();
include_once('../conn/Crud.php');

$crud = new Crud();

if(isset($_POST['add'])) {
    $tenant_id = $crud->escape_string($_POST['tenant_id']);
    $date_created = $crud->escape_string($_POST['date_created']);
    $due_date = $crud->escape_string($_POST['due_date']);
    $total_amount = $crud->escape_string($_POST['total_amount']);
    $status = $crud->escape_string($_POST['status']);

    $sql = "INSERT INTO `Invoices`(`tenant_id`, `date_created`, `due_date`, `total_amount`, `status`)
            VALUES ('$tenant_id', '$date_created', '$due_date', '$total_amount', '$status')";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Invoice added successfully';
    } else {
        $_SESSION['message'] = 'Cannot add invoice';
    }

    header('location: ../admin/dashboard/invoices.php');
} elseif(isset($_POST['edit'])) {
    $id = $crud->escape_string($_POST['id']);
    $tenant_id = $crud->escape_string($_POST['tenant_id']);
    $date_created = $crud->escape_string($_POST['date_created']);
    $due_date = $crud->escape_string($_POST['due_date']);
    $total_amount = $crud->escape_string($_POST['total_amount']);
    $status = $crud->escape_string($_POST['status']);

    $sql = "UPDATE Invoices SET 
            tenant_id = '$tenant_id', 
            date_created = '$date_created', 
            due_date = '$due_date', 
            total_amount = '$total_amount', 
            status = '$status' 
            WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Invoice updated successfully';
    } else {
        $_SESSION['message'] = 'Cannot update invoice';
    }

    header('location: ../admin/dashboard/invoices.php');
} elseif(isset($_POST['delete'])) {
    $id = $crud->escape_string($_POST['id']);
    $sql = "DELETE FROM Invoices WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Invoice deleted successfully';
    } else {
        $_SESSION['message'] = 'Cannot delete invoice';
    }

    header('location: ../admin/dashboard/invoices.php');
} else {
    $_SESSION['message'] = 'Invalid action';
    header('location: ');
}
?>