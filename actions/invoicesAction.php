<?php
session_start();
include_once('../conn/Crud.php');

$crud = new Crud();

if(isset($_POST['add'])) {
    $tenant_id = $crud->escape_string($_POST['tenant_id']);
    $due_date = $crud->escape_string($_POST['due_date']);
    $current_bill = $crud->escape_string($_POST['current_bill']);

    $sql = "INSERT INTO `Invoices`(`tenant_id`, `due_date`, `current_bill`, `status`)
            VALUES ('$tenant_id',  '$due_date', '$current_bill', 'pending')";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Invoice added successfully';
    } else {
        $_SESSION['message'] = 'Cannot add invoice';
    }

    header('location: ../admin/dashboard/invoices.php');
} elseif(isset($_POST['edit'])) {
    $id = $crud->escape_string($_POST['id']);
    $date_created = $crud->escape_string($_POST['date_created']);
    $due_date = $crud->escape_string($_POST['due_date']);
    $current_bill = $crud->escape_string($_POST['current_bill']);

    // Calculate prev_bill and total_amount based on existing values
    $sqlGetPreviousValues = "SELECT current_bill, prev_bill, total_amount, tenant_id FROM Invoices WHERE id = '$id'";
    $previousValues = $crud->read($sqlGetPreviousValues);

    $prev_bill = $previousValues[0]['current_bill'];
    $total_amount = $prev_bill + $current_bill;
    $tenant_id = $previousValues[0]['tenant_id'];

    // Update the values in the database
    $sql = "UPDATE Invoices SET 
            date_created = '$date_created', 
            due_date = '$due_date', 
            current_bill = '$current_bill',
            prev_bill = '$prev_bill',
            total_amount = '$total_amount'
            WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Invoice updated successfully';
    } else {
        $_SESSION['message'] = 'Cannot update invoice';
    }

    // Update tenant's balance based on the new total amount
    $sqlUpdateBalance = "UPDATE Tenants SET balance = '$total_amount' WHERE id = '$tenant_id'";
    $crud->execute($sqlUpdateBalance);

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