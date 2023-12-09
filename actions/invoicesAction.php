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
    $tenant_id = $crud->escape_string($_POST['tenant_id']); // Assuming you have a field in your form for tenant_id
    $payment_date = $crud->escape_string($_POST['payment_date']);
    $amount_paid = $crud->escape_string($_POST['amount_paid']);

    $sql = "UPDATE Payments SET 
            tenant_id = '$tenant_id', 
            payment_date = '$payment_date', 
            amount_paid = '$amount_paid'
            WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Payment updated successfully';
    } else {
        $_SESSION['message'] = 'Cannot update payment';
    }

    header('location: ../admin/dashboard/payments.php');

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